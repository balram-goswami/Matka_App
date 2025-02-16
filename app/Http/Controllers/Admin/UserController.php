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
            ->get();

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
            ->get();

        // Fetch all bid transactions for these players in one query
        $exposer = BidTransaction::whereIn('user_id', $players->pluck('user_id'))
            ->where('status', 'submitted')
            ->whereNull('bid_result')
            ->get();

        $view = 'Admin.Users.ViewSubAdminDetails';
        return view('Admin', compact('view', 'players', 'user', 'exposer'));
    }


    public function blockUserByAdmin($id)
    {
        $user = User::findOrFail($id);

        // Toggle status
        $user->status = ($user->status === 'Active') ? 'Block' : 'Active';
        $user->save();

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
        $newUser = User::latest()->first();
        Session::flash('success', "New User (ID: {$newUser->name}) saved successfully.");
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
            Session::flash('warning', "No Ads found!!!!.");
            return Redirect::back();
        }
        $this->service->delete($user);
        Session::flash('success', "Ads deleted.");
        return Redirect::route("users.index");
    }

    public function resultDashboard()
    {
        $user = $this->service->select();
        $numberGame = getPostsByPostType('optiongame', 0, 'new', true);
        $sattaGame = getPostsByPostType('numberGame', 0, 'new', true);
        $results = GameResult::all();

        $gameNames = [];

        foreach ($results as $result) {
            $game = Posts::where('post_id', $result->game_id)->first();
            $gameNames[$result->game_id] = $game ? $game->post_title : 'Unknown Game';
        }

        $view = 'Admin.Results.ResultDashboard';

        return view('Admin', compact('view', 'user', 'numberGame', 'sattaGame', 'results', 'gameNames'));
    }


    public function paymentRequest()
    {
        $user = $this->service->select();
        $view = 'Admin.Results.PaymentPage';
        $payment = WalletTransactions::all();
        return view('Admin', compact('view', 'user', 'payment'));
    }

    public function sattaResult(Request $request)
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

        // Check if result is already declared
        $gameResult = GameResult::where('game_id', $request->game_id)->latest()->first();

        if ($gameResult) {
            $currentTime = now(); // Current timestamp
            $resultTime = $gameResult->created_at; // Timestamp when the result was declared

            // Check if the result was declared within the last 2 hours
            if ($resultTime->diffInHours($currentTime) < 2) {
                return redirect()->back()->with('danger', 'Result Already Declared Within the Last 2 Hours');
            }
        }

        try {
            // Save the game result
            GameResult::create([
                'game_id' => $request->game_id,
                'result' => $request->result,
            ]);

            $bidTable = BidTransaction::where('game_id', $request->game_id)
                ->where('bid_result', NULL)
                ->get();


            foreach ($bidTable as $table) {
                $gameId = $request->game_id;
                $result = $request->result;
                $bidResult = null;

                if ($table->harf_digit === 'oddEven') {
                    $bidResult = ($result % 2 === 0) ? 'EVEN' : 'ODD';
                } elseif ($table->harf_digit === 'Ander') {
                    $bidResult = intval(substr($result, 0, 1)); // First digit
                } elseif ($table->harf_digit === 'Bahar') {
                    $bidResult = intval(substr($result, 1, 1)); // Second digit
                } else {
                    $bidResult = $result; // Default case
                }

                // Ensure filtering by harf_digit to update the correct bid
                BidTransaction::where('game_id', $gameId)
                    ->where('harf_digit', $table->harf_digit) // Add this condition
                    ->update([
                        'bid_result' => $bidResult, // Use $bidResult instead of $result
                        'result_status' => DB::raw("CASE WHEN answer = '" . addslashes($bidResult) . "' THEN 'win' ELSE 'loss' END"),
                    ]);
            }

            // Ensure a single success response after all iterations
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

        // Check if result is already declared
        $games = GameResult::where('game_id', $request->game_id)->get();
        if ($games->isNotEmpty()) {
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
                ->update([
                    'bid_result' => $request->result,
                    'result_status' => DB::raw("CASE WHEN answer = '$request->result' THEN 'win' ELSE 'loss' END"),
                ]);

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

            $gameResult = GameResult::where('game_id', $game_id)->get('result')->first();

            $getgame = getPostsByPostType('optiongame', 0, 'new', true);
            $game = $getgame->where('post_id', $game_id)->first();

            $jantriData = BidTransaction::where('game_id', $game_id)
                ->selectRaw('answer, SUM(admin_cut) as total_bid, SUM(win_amount + subadminget) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $view = 'Admin.Jantri.Table';
            return view('Admin', compact('view', 'jantriData', 'gameType', 'game', 'gameResult'));
        } else {
            $game_id = $request->sattaGame;
            $time = $request->sattaGameTime;
            $date = $request->date;

            $gameType = 'satta';
            $gameResult = GameResult::where('game_id', $game_id)->first(['result']); // Using first() to avoid collections

            // Merge date and time into a DateTime format
            $selectedDateTime = Carbon::parse("$date $time");

            // Get the timestamp for 5 hours before the updated_at field
            $timeLimit = Carbon::now()->subHours(5);

            $jantriData = BidTransaction::where('game_id', $game_id)
                ->where('updated_at', '>=', $timeLimit) // Only results updated in the last 5 hours
                ->where('updated_at', '<=', $selectedDateTime) // Ensure records match the selected date-time
                ->selectRaw('answer, SUM(admin_cut) as total_bid, SUM(win_amount + subadminget) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $view = 'Admin.Jantri.Table';
            return view('Admin', compact('view', 'jantriData', 'gameType', 'gameResult'));
        }

        return redirect()->back()->with('danger', 'No Jantri Found.');
    }
}
