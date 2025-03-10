<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session, DataTables, Redirect, Validator, Form;
use App\Services\{
    UserService
};
use Illuminate\Support\Facades\DB;
use App\Models\{
    GameResult,
    BidTransaction,
    Wallet,
    WalletTransactions,
    Posts,
    User
};
use Carbon\Carbon;


class UserController extends Controller
{
    protected $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'subadmin')
            ->with(['wallet', 'players'])
            ->paginate(25);

        $view = 'Admin.Users.Index';
        return view('Admin', compact('view', 'users'));
    }

    public function viewSubadmin($id)
    {
        // Fetch Subadmin
        $user = User::where('user_id', $id)->first();

        // Fetch Players with Wallets and Players (Eager Loading)
        $players = User::where('parent', $id)
            ->with(['wallet', 'players'])
            ->paginate(25);

        $exposers = []; // Store exposer amounts for each user

        foreach ($players as $list) {
            $exposers[$list->user_id] = BidTransaction::where('user_id', $list->user_id)
                ->where('status', 'submitted')
                ->whereNull('bid_result')
                ->sum('subadmin_amount'); // Sum directly in the query
        }

        $payment = WalletTransactions::where('user_id', $id)->paginate(25);

        $view = 'Admin.Users.ViewSubAdminDetails';
        return view('Admin', compact('view', 'players', 'user', 'exposers', 'payment'));
    }

    public function viewSubadminplayer($id)
    {
        $players = User::where('user_id', $id)
            ->with(['wallet', 'players'])
            ->get()->first();

        $exposers = BidTransaction::where('user_id', $id)
            ->where('status', 'submitted')
            ->whereNull('bid_result')
            ->paginate(25);


        $payment = WalletTransactions::all();

        $view = 'Admin.Users.ViewSubAdminPlayer';
        return view('Admin', compact('view', 'players', 'exposers', 'payment'));
    }


    public function blockUserByAdmin($id)
    {
        $user = User::findOrFail($id);

        // Toggle user status
        $newStatus = ($user->status === 'Active') ? 'BlockByAdmin' : 'Active';
        $user->status = $newStatus;
        $user->save();

        // If the user is a subadmin, block/unblock their players
        if ($user->role === 'subadmin') {
            $players = User::where('role', 'player')->where('parent', $user->user_id)->get();
            foreach ($players as $player) {
                $player->status = $newStatus; // Apply the same status change as subadmin
                $player->save();
            }
        }

        return redirect()->back()->with('success', 'User status updated successfully.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = $this->service->select();
        $view = 'Admin.Users.AddEdit';
        return view('Admin', compact('view', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->service->store($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$user = $this->service->get($id)) {
            Session::flash('success', "User not found in our system.");
            return redirect()->route('users.index');
        }
        $view = 'Admin.Users.AddEdit';
        return view('Admin', compact('view', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$user = $this->service->get($id)) {
            Session::flash('success', "User not found in our system.");
            return redirect()->back();
        }
        $this->service->update($request, $user);
        Session::flash('success', "User Details update successfully.");
        return redirect()->back();
    }

    public function changePassword()
    {
        $user = getCurrentUser();
        $view = 'Admin.Users.ChangePassword';
        return view('Admin', compact('view', 'user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $user = $this->service->get($id);
        if (!$user) {
            Session::flash('warning', "No User found!!!!.");
            return Redirect::back();
        }

        $user->delete(); // This will soft delete the user

        // If the user is a subadmin, block/unblock their players
        if ($user->role === 'subadmin') {
            $players = User::where('role', 'player')->where('parent', $user->user_id)->get();
            foreach ($players as $player) {
                $player->delete();
            }
        }
        Session::flash('success', "User soft deleted.");
        return Redirect::route("users.index");
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->restore();
            Session::flash('success', "User restored successfully.");
        } else {
            Session::flash('warning', "User not found.");
        }

        return Redirect::route("users.index");
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->forceDelete(); // Permanently deletes the user
            Session::flash('success', "User permanently deleted.");
        } else {
            Session::flash('warning', "User not found.");
        }

        return Redirect::route("users.index");
    }

    public function resultDashboard()
    {
        $user = $this->service->select();
        $numberGame = getPostsByPostType('optiongame', 0, 'new', true);
        $sattaGame = getPostsByPostType('numberGame', 0, 'new', true);
        $results = GameResult::orderBy('created_at', 'DESC')->paginate(25);

        $gameNames = [];
        $filteredSattaGame = [];
        $now = Carbon::now('Asia/Kolkata');

        foreach ($sattaGame as $satta) {
            if (empty($satta['extraFields']['open_time']) || empty($satta['extraFields']['close_time'])) {
                continue;
            }

            $timeFormat = (stripos($satta['extraFields']['open_time'], 'AM') !== false || stripos($satta['extraFields']['open_time'], 'PM') !== false)
                ? 'h:i A'
                : 'H:i';

            try {
                $today = $now->toDateString();
                $tomorrow = $now->copy()->addDay()->toDateString();

                $openTime = Carbon::createFromFormat("Y-m-d {$timeFormat}", "{$today} {$satta['extraFields']['open_time']}", 'Asia/Kolkata');
                $closeTime = Carbon::createFromFormat("Y-m-d {$timeFormat}", "{$today} {$satta['extraFields']['close_time']}", 'Asia/Kolkata');

                if ($closeTime->lessThan($openTime)) {
                    $closeTime->addDay();
                }

                if ($openTime->lessThan($closeTime)) {
                    $openTime->addDay();
                }

                if ($now->greaterThan($closeTime) && $now->lessThan($openTime)) {
                    $filteredSattaGame[] = $satta;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        foreach ($results as $result) {
            $game = Posts::where('post_id', $result->game_id)->first();
            $gameNames[$result->game_id] = $game ? $game->post_title : 'Unknown Game';
        }

        $view = 'Admin.Results.ResultDashboard';

        return view('Admin', compact('view', 'user', 'numberGame', 'filteredSattaGame', 'results', 'gameNames'));
    }


    public function paymentRequest()
    {
        $user = $this->service->select();
        $view = 'Admin.Results.PaymentPage';
        $payment = WalletTransactions::where('user_id', 1)->paginate(25);

        return view('Admin', compact('view', 'user', 'payment'));
    }


    public function chart()
    {
        $view = 'Admin.Users.Chart';
        return view('Admin', compact('view'));
    }

    public function sattaResult(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'game_id' => 'required',
                'result' => 'required|string|max:255'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formattedResult = str_pad($request->result, 2, '0', STR_PAD_LEFT);
        $currentTime = now();

        // Fetch game details
        $sattaGames = getPostsByPostType('numberGame', 0, 'order', true);
        $game = collect($sattaGames)->firstWhere('post_id', $request->game_id);

        if (!$game) {
            return redirect()->back()->with('danger', 'Invalid game ID');
        }

        $openTime = Carbon::parse($game['extraFields']['open_time']);
        $closeTime = Carbon::parse($game['extraFields']['close_time']);

        // Handle case where close time is today but open time is the next day
        if ($closeTime->greaterThan($openTime)) {
            $openTime->addDay();
        }

        // Ensure result is declared only once per game cycle
        $lastGameResult = GameResult::where('game_id', $request->game_id)
            ->where('created_at', '>=', $closeTime->format('Y-m-d H:i:s'))
            ->exists();

        if ($lastGameResult) {
            return redirect()->back()->with('danger', 'Result Already Declared. New result can be declared after the next closing time.');
        }

        // Ensure result can be declared only **after closing and before next opening**
        if (!($currentTime->greaterThan($closeTime) && $currentTime->lessThan($openTime))) {
            return redirect()->back()->with('danger', 'Result can only be declared after closing time and before the next opening time.');
        }

        try {
            GameResult::create([
                'game_id' => $request->game_id,
                'result' => $formattedResult,
            ]);

            $bidTable = BidTransaction::where('game_id', $request->game_id)
                ->whereNull('bid_result')
                ->where('status', 'submitted')
                ->get();

            foreach ($bidTable as $table) {
                $gameId = $request->game_id;
                $result = $formattedResult; // Use formatted result
                $bidResult = null;

                if ($table->harf_digit === 'oddEven') {
                    $bidResult = ($result % 2 === 0) ? 'EVEN' : 'ODD';
                } elseif ($table->harf_digit === 'Andar') {
                    $bidResult = intval(substr($result, 0, 1)); // First digit
                } elseif ($table->harf_digit === 'Bahar') {
                    $bidResult = intval(substr($result, 1, 1)); // Second digit
                } else {
                    $bidResult = $result; // Default case
                }

                // Ensure filtering by harf_digit to update the correct bid
                BidTransaction::where('game_id', $gameId)
                    ->where('harf_digit', $table->harf_digit)
                    ->whereNull('bid_result')
                    ->where('status', 'submitted')
                    ->update([
                        'bid_result' => $bidResult,
                        'result_status' => DB::raw("CASE WHEN answer = '" . addslashes($bidResult) . "' THEN 'win' ELSE 'loss' END"),
                    ]);
            }
            // Fetch winning bids
            $winningBids = BidTransaction::where('game_id', $request->game_id)
                ->where('result_status', 'win')
                ->where('status', 'submitted')
                ->get();

            if ($winningBids->isNotEmpty()) {
                $claimResult = $this->clameWinAmount();
                if ($claimResult instanceof \Illuminate\Http\RedirectResponse) {
                    return $claimResult;
                }
            }

            return redirect()->back()->with('success', 'Bid results updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error saving game result: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving the result');
        }
    }


    public function gameResult(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'game_id' => 'required',
                'result' => 'required|string|max:255',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $games = GameResult::where('game_id', $request->game_id)->exists();
        if ($games) {
            return redirect()->back()->with('danger', 'Result Already Declared');
        }

        try {
            // Save the game result
            GameResult::create([
                'game_id' => $request->game_id,
                'result' => $request->result,
            ]);

            // Update bid transactions
            BidTransaction::where('game_id', $request->game_id)
                ->where('status', 'submitted')
                ->update([
                    'bid_result' => $request->result,
                    'result_status' => DB::raw("CASE WHEN answer = '$request->result' THEN 'win' ELSE 'loss' END"),
                ]);

            // Fetch winning bids
            $winningBids = BidTransaction::where('game_id', $request->game_id)
                ->where('result_status', 'win')
                ->get();

            if ($winningBids->isNotEmpty()) {
                $claimResult = $this->clameWinAmount();
                if ($claimResult instanceof \Illuminate\Http\RedirectResponse) {
                    return $claimResult;
                }
            }

            return redirect()->back()->with('success', 'Result Saved');
        } catch (\Exception $e) {
            \Log::error('Error saving game result: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving the result');
        }
    }


    public function confermPayment($id)
    {
        // Find the pending wallet transaction by ID
        $pay = WalletTransactions::where('id', $id)
            ->where('request_status', 'pending')
            ->first();

        // Check if the transaction exists and is pending
        if (!$pay) {
            return redirect()->back()->with('danger', 'Transaction not found or already processed.');
        }

        // Update the transaction status
        $pay->request_status = 'complete';
        $pay->save();

        // Find the associated wallet
        $wallet = Wallet::find($pay->wallet_id);
        $pUser = getcurrentUser();
        $pWallet = Wallet::find($pUser->user_id);

        if (!$pWallet) {
            return redirect()->back()->with('danger', 'Wallet not found.');
        }
        $pWallet->balance -= $pay->deposit_amount; // Increment the balance
        $pWallet->save();

        if (!$wallet) {
            return redirect()->back()->with('danger', 'Wallet not found.');
        }

        // Update the wallet balance
        $wallet->balance += $pay->deposit_amount; // Increment the balance
        $wallet->save();

        return redirect()->back()->with('success', 'Payment successfully confirmed.');
    }

    public function gameOptions(Request $request)
    {
        $game = getPostsByPostType('optiongame', 0, 'new', true)->where('post_id', $request->game_id);

        foreach ($game as $currentGame) {
            if ($currentGame) {
                return response()->json([
                    'answers' => [
                        $currentGame['extraFields']['answer_one'],
                        $currentGame['extraFields']['answer_two']
                    ]
                ]);
            }
            return response()->json(['answers' => []]);
        }
    }

    public function viewPayment($id)
    {
        $payment = WalletTransactions::where('id', $id)->get()->first();
        $user = getUser($payment->user_id);
        $view = 'Admin.Results.ViewPaymentRequest';
        return view('Admin', compact('view', 'user', 'payment'));
    }

    public function withdralRequest(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'id'                => 'required|exists:wallet_transactions,id',
            'wallet_id'         => 'required|exists:wallets,id',
            'parent_id'         => 'nullable|exists:wallets,user_id',
            'transaction_type'  => 'required|string',
            'utr_number'        => 'required|string|unique:wallet_transactions,utr_number',
        ]);

        // Fetch the pending transaction
        $pay = WalletTransactions::where('id', $request->id)
            ->where('request_status', 'pending')
            ->first();

        if (!$pay) {
            return redirect()->back()->with('danger', 'Transaction not found or already processed.');
        }

        $adminwallet = Wallet::where('user_id', 1)->first();
        $userWallet = Wallet::where('id', $request->wallet_id)->first();

        if (!$adminwallet) {
            return redirect()->back()->with(['danger' => 'Admin wallet not found.'])->withInput();
        }

        if (!$userWallet) {
            return redirect()->back()->with(['danger' => 'User wallet not found.'])->withInput();
        }

        // Check if the admin has enough balance
        if ($adminwallet->balance < $pay->withdraw_amount) {
            return redirect()->back()->with(['danger' => 'Insufficient balance in admin wallet.'])->withInput();
        }

        // Use a transaction to prevent race conditions
        DB::transaction(function () use ($adminwallet, $userWallet, $pay, $request) {
            $adminwallet->balance = $adminwallet->balance + $pay->withdraw_amount;
            $adminwallet->save();

            $userWallet->balance = $userWallet->balance - $pay->withdraw_amount;
            $userWallet->save();

            $pay->update([
                'request_status'    => 'complete',
                'transaction_type'  => $request->transaction_type,
                'utr_number'        => $request->utr_number,
                'remark'            => 'Paid From Admin Account'
            ]);
        });

        return redirect()->back()->with('success', 'Withdrawal request processed successfully.');
    }


    public function jantriTable()
    {
        $tossGame = getPostsByPostType('optiongame', 0, 'new', true);
        $sattaGame = getPostsByPostType('numberGame', 0, 'new', true);
        $view = 'Admin.Jantri.JantriView';
        return view('Admin', compact('view', 'tossGame', 'sattaGame'));
    }

    public function jantri(Request $request)
    {
        if ($request->tossGame == !NULL) {
            $game_id = $request->tossGame;
            $gameType = 'option';
            $c_user = getCurrentUser();

            $gameResult = GameResult::where('game_id', $game_id)->get('result')->first();

            $getgame = getPostsByPostType('optiongame', 0, 'new', true);
            $game = $getgame->where('post_id', $game_id)->first();

            $jantriData = BidTransaction::where('game_id', $game_id)
                ->selectRaw('answer, SUM(admin_dif) as total_bid, SUM(winamount_from_admin) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $view = 'Admin.Jantri.Table';
            return view('Admin', compact('view', 'jantriData', 'gameType', 'game', 'gameResult'));
        } else {

            $game_id = $request->sattaGame;
            $time = $request->sattaGameTime;
            $date = $request->gamedate;

            $gameType = 'satta';
            $gameResult = GameResult::where('game_id', $game_id)->whereDate('created_at', $date)->first(['result']);


            $jantriData = BidTransaction::where('game_id', $game_id)
                ->where('harf_digit', NULL)
                ->whereDate('updated_at', $date)
                ->selectRaw('answer, SUM(admin_dif) as total_bid, SUM(winamount_from_admin) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $jantriOddEven = BidTransaction::where('game_id', $game_id)
                ->where('harf_digit', 'oddEven')
                ->whereDate('updated_at', $date)  // Corrected condition
                ->selectRaw('answer, SUM(subadmin_dif) as total_bid, SUM(win_amount) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $jantriandar = BidTransaction::where('game_id', $game_id)
                ->where('harf_digit', 'Andar')
                ->whereDate('updated_at', $date)  // Corrected condition
                ->selectRaw('answer, SUM(subadmin_dif) as total_bid, SUM(win_amount) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $jantribahar = BidTransaction::where('game_id', $game_id)
                ->where('harf_digit', 'Bahar')
                ->whereDate('updated_at', $date)  // Corrected condition
                ->selectRaw('answer, SUM(subadmin_dif) as total_bid, SUM(win_amount) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $view = 'Admin.Jantri.Table';
            return view('Admin', compact('view', 'jantriData', 'gameType', 'gameResult', 'jantriOddEven', 'jantriandar', 'jantribahar'));
        }
        return redirect()->back()->with('danger', 'No Jantri Found.');
    }

    public function depositToAdmin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:wallets,user_id',
                'balance' => 'required|numeric|min:1',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $adminWallet = Wallet::where('user_id', $request->user_id)->first();
        $adminWallet->balance = $adminWallet->balance + $request->balance;
        $adminWallet->created_at = dateTime();
        $adminWallet->save();

        $TransactionsUser = new WalletTransactions();
        $TransactionsUser->user_id = $request->user_id;
        $TransactionsUser->tofrom_id = 1;
        $TransactionsUser->credit = $request->balance;
        $TransactionsUser->balance = $adminWallet->balance;
        $TransactionsUser->remark = 'Add Balance to self';
        $TransactionsUser->created_at = dateTime();
        $TransactionsUser->save();

        return redirect()->back()->with('success', 'Balance Deposit successfully.');
    }

    public function withdrawalToAdmin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:wallets,user_id',
                'balance' => 'required|numeric|min:1',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $adminWallet = Wallet::where('user_id', $request->user_id)->first();
        $adminWallet->balance = $adminWallet->balance - $request->balance;
        $adminWallet->created_at = dateTime();
        $adminWallet->save();

        $TransactionsUser = new WalletTransactions();
        $TransactionsUser->user_id = $request->user_id;
        $TransactionsUser->tofrom_id = 1;
        $TransactionsUser->debit = $request->balance;
        $TransactionsUser->balance = $adminWallet->balance;
        $TransactionsUser->remark = 'Withdrawl Balance from self account';
        $TransactionsUser->created_at = dateTime();
        $TransactionsUser->save();

        return redirect()->back()->with('success', 'Balance Withdrawl successfully.');
    }

    public function addbalancebyadmin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:wallets,user_id',
                'balance' => 'required|numeric|min:1',
                'delete_reason' => 'nullable'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the user's wallet account
        $account = Wallet::where('user_id', $request->user_id)->first();

        // Get the current logged-in user (assumed function)
        $pUser = getCurrentUser();
        $parent = Wallet::where('user_id', $pUser->user_id)->first();

        // Check if parent wallet exists and has enough balance
        if (!$parent) {
            return redirect()->back()->with('danger', 'Parent account not found');
        }

        if ($parent->balance < $request->balance) {
            return redirect()->back()->with('danger', 'Insufficient balance');
        }

        // Check if recipient account exists
        if (!$account) {
            return redirect()->back()->with('danger', 'Account not found');
        }

        // Deduct from parent's wallet
        $parent->balance -= $request->balance;
        $parent->save();

        // Add to recipient's wallet
        $account->balance += $request->balance;
        $account->save();

        $walletUpdate = WalletTransactions::create([
            'user_id'         => $request->user_id,
            'tofrom_id'       => $pUser->user_id,
            'credit'          => $request->balance,
            'balance'          => $account->balance,
            'remark'          => $request->delete_reason ?? 'Credited by Admin',
            'created_at'      => now(),
        ]);
        $walletUpdate = WalletTransactions::create([
            'user_id'         => $pUser->user_id,
            'tofrom_id'       => $request->user_id,
            'debit'          => $request->balance,
            'balance'          => $parent->balance,
            'remark'          => $request->delete_reason ?? 'Debited by Admin',
            'created_at'      => now(),
        ]);
        $walletUpdate->save();

        return redirect()->back()->with('success', 'Balance transferred successfully.');
    }

    public function deletebalancebyadmin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:wallets,user_id',
                'balance' => 'required|numeric|min:1',
                'delete_reason' => 'nullable'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the user's wallet account
        $account = Wallet::where('user_id', $request->user_id)->first();

        // Get the current logged-in user (assumed function)
        $pUser = getCurrentUser();
        $parent = Wallet::where('user_id', $pUser->user_id)->first();

        // Check if parent wallet exists and has enough balance
        if (!$parent) {
            return redirect()->back()->with('danger', 'Parent account not found');
        }

        // Check if recipient account exists
        if (!$account) {
            return redirect()->back()->with('danger', "$account->name Account not found");
        }

        // Deduct from parent's wallet
        $parent->balance += $request->balance;
        $parent->save();

        // Add to recipient's wallet
        $account->balance -= $request->balance;
        $account->save();

        $walletUpdate = WalletTransactions::create([
            'user_id'         => $request->user_id,
            'tofrom_id'       => $pUser->user_id,
            'debit'          => $request->balance,
            'balance'          => $account->balance,
            'remark'          => $request->delete_reason ?? 'Debited by Admin',
            'created_at'      => now(),
        ]);
        $walletUpdate = WalletTransactions::create([
            'user_id'         => $pUser->user_id,
            'tofrom_id'       => $request->user_id,
            'credit'          => $request->balance,
            'balance'          => $parent->balance,
            'remark'          => $request->delete_reason ?? 'Credited by Admin',
            'created_at'      => now(),
        ]);
        $walletUpdate->save();

        return redirect()->back()->with('success', 'Balance transferred successfully.');
    }


    private function clameWinAmount()
    {
        $bids = BidTransaction::where('result_status', 'win')->where('status', 'submitted')->get();

        if ($bids->isEmpty()) {
            return redirect()->back()->with('error', 'No winning bid found.');
        }

        \DB::beginTransaction();
        try {
            foreach ($bids as $bid) {
                // Update bid status to claimed
                $bid->result_status = 'claimed';
                $bid->save();

                $winning_amount = $bid->win_amount;
                $game = Posts::where('post_id', $bid->game_id)->first();
                $gameName = $game ? $game->post_title : 'Unknown Game';

                // Get wallets
                $adminwallet = Wallet::where('user_id', 1)->first();
                $subadminwallet = Wallet::where('user_id', $bid->parent_id)->first();
                $playerWallet = Wallet::where('user_id', $bid->user_id)->first();

                if (!$adminwallet || !$playerWallet) {
                    throw new \Exception('Required wallet not found.');
                }

                // Credit to player wallet
                $playerWallet->balance += $winning_amount;
                $playerWallet->save();

                WalletTransactions::create([
                    'user_id' => $bid->user_id,
                    'tofrom_id' => 1,
                    'credit' => $winning_amount,
                    'balance' => $playerWallet->balance,
                    'remark' => $gameName . ' Game Win Amount',
                    'created_at' => now(),
                ]);

                // Debit from admin wallet
                $adminwallet->balance -= $winning_amount;
                $adminwallet->save();

                WalletTransactions::create([
                    'user_id' => 1,
                    'tofrom_id' => $bid->user_id,
                    'debit' => $winning_amount,
                    'balance' => $adminwallet->balance,
                    'remark' => $gameName . ' Game Win Amount to ',
                    'created_at' => now(),
                ]);

                // Handle subadmin share if applicable
                if ($bid->win_amount > $bid->winamount_from_admin) {
                    $subAdminGet = $bid->win_amount - $bid->winamount_from_admin;

                    $adminwallet->balance += $subAdminGet;
                    $adminwallet->save();

                    WalletTransactions::create([
                        'user_id' => 1,
                        'tofrom_id' => $bid->parent_id,
                        'credit' => $subAdminGet,
                        'balance' => $adminwallet->balance,
                        'remark' => $gameName . ' Game Amount From ',
                        'created_at' => now(),
                    ]);

                    if ($subadminwallet) {
                        $subadminwallet->balance -= $subAdminGet;
                        $subadminwallet->save();

                        WalletTransactions::create([
                            'user_id' => $bid->parent_id,
                            'tofrom_id' => 1,
                            'debit' => $subAdminGet,
                            'balance' => $subadminwallet->balance,
                            'remark' => $gameName . ' Game Amount Paid to ',
                            'created_at' => now(),
                        ]);
                    }
                } else {
                    $subAdminGet = $bid->winamount_from_admin - $bid->win_amount;

                    $adminwallet->balance -= $subAdminGet;
                    $adminwallet->save();

                    WalletTransactions::create([
                        'user_id' => 1,
                        'tofrom_id' => $bid->parent_id,
                        'debit' => $subAdminGet,
                        'balance' => $adminwallet->balance,
                        'remark' => $gameName . ' Game Amount Paid to ',
                        'created_at' => now(),
                    ]);

                    if ($subadminwallet) {
                        $subadminwallet->balance += $subAdminGet;
                        $subadminwallet->save();

                        WalletTransactions::create([
                            'user_id' => $bid->parent_id,
                            'tofrom_id' => 1,
                            'credit' => $subAdminGet,
                            'balance' => $subadminwallet->balance,
                            'remark' => $gameName . ' Game Amount From ',
                            'created_at' => now(),
                        ]);
                    }
                }
            }

            \DB::commit();
            return redirect()->back()->with('success', 'Result Declared Successfully and Win Amount Paid.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('danger', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function deleteBidByAdmin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'delete_reason' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bid = BidTransaction::find($id);

        if (!$bid) {
            return redirect()->back()->with('danger', 'Bid not found.');
        }

        try {
            DB::beginTransaction();
            $bid->delete();

            // Fetch wallets in advance to reduce queries
            $adminWallet = Wallet::where('user_id', 1)->first();
            $parentWallet = Wallet::where('user_id', $bid->parent_id)->first();
            $playerWallet = Wallet::where('user_id', $bid->user_id)->first();

            // Ensure wallets exist before modifying balances
            if (!$adminWallet || !$parentWallet || !$playerWallet) {
                DB::rollBack();
                return redirect()->back()->with('danger', 'Wallet not found.');
            }

            // Update Admin Wallet
            $adminWallet->balance -= $bid->admin_amount;
            $adminWallet->save();

            WalletTransactions::create([
                'user_id' => 1,
                'tofrom_id' => $bid->parent_id,
                'debit' => $bid->admin_amount,
                'balance' => $adminWallet->balance,
                'remark' => 'Bid Delete Due To - ' . $request->delete_reason,
                'created_at' => now(),
            ]);

            // Update Parent Wallet
            $parentWallet->balance += $bid->admin_amount;
            $parentWallet->save();

            WalletTransactions::create([
                'user_id' => $bid->parent_id,
                'tofrom_id' => 1,
                'credit' => $bid->admin_amount,
                'balance' => $parentWallet->balance,
                'remark' => 'Bid Delete Due To - ' . $request->delete_reason,
                'created_at' => now(),
            ]);

            // Deduct Subadmin Amount from Parent Wallet
            $parentWallet->balance -= $bid->subadmin_amount;
            $parentWallet->save();

            WalletTransactions::create([
                'user_id' => $bid->parent_id,
                'tofrom_id' => $bid->user_id,
                'debit' => $bid->subadmin_amount,
                'balance' => $parentWallet->balance,
                'remark' => 'Bid Delete Due To - ' . $request->delete_reason,
                'created_at' => now(),
            ]);

            // Update Player Wallet
            $playerWallet->balance += $bid->subadmin_amount;
            $playerWallet->save();

            WalletTransactions::create([
                'user_id' => $bid->user_id,
                'tofrom_id' => $bid->parent_id,
                'credit' => $bid->subadmin_amount,
                'balance' => $playerWallet->balance,
                'remark' => 'Bid Delete Due To - ' . $request->delete_reason,
                'created_at' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Bid deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('danger', 'Failed to delete bid: ' . $e->getMessage());
        }
    }
}
