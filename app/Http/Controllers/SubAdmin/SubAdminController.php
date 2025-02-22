<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session, DataTables, Redirect, DB, Validator, Form;
use App\Services\{
    UserService
};
use App\Models\{
    User,
    Wallet,
    BidTransaction,
    WalletTransactions,
    GameResult
};
use Carbon\Carbon;

class SubAdminController extends Controller
{
    protected $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function subadminDashboard()
    {
        $user = getCurrentUser();
        $wallet = Wallet::where('user_id', $user->user_id)->get()->first();
        $players = User::where('parent', $user->user_id)->get();
        $pwdMsg = User::where('user_id', $user->user_id)->get()->first();

        $view = 'SubAdmin.SubAdmin.Index';
        return view('Admin', compact('view', 'wallet', 'players', 'pwdMsg'));
    }

    public function viewPlayers()
    {
        $pId = getCurrentUser();
        $users = User::where('parent', $pId->user_id)->get();
        $exposers = []; // Store exposer amounts for each user

        foreach ($users as $user) {
            $exposers[$user->user_id] = BidTransaction::where('user_id', $user->user_id)
                ->where('status', 'submitted')
                ->whereNull('bid_result')
                ->sum('subadmin_amount'); // Sum directly in the query
        }

        $view = 'SubAdmin.SubAdmin.AddPlayers';

        return view('Admin', compact('view', 'users', 'exposers'));
    }


    public function subadminAddUsers($id)
    {
        $user = User::where('user_id', $id)->first();
        $wallet = Wallet::where('user_id', $id)->first();
        $bids = BidTransaction::where('user_id', $id)->get();
        $win = BidTransaction::where('user_id', $id)->where('result_status', 'claimed')->get();
        $loss = BidTransaction::where('user_id', $id)->where('result_status', 'loss')->get();
        $panding = BidTransaction::where('user_id', $id)->where('result_status', NULL)->get();
        $payment = WalletTransactions::where('user_id', $id)->get();
        $exposer = BidTransaction::where('user_id', $id)
            ->where('status', 'submitted')
            ->whereNull('bid_result')
            ->get();

        $view = 'SubAdmin.SubAdmin.PlayerDetails';
        return view('Admin', compact('view', 'user', 'wallet', 'bids', 'win', 'loss', 'panding', 'payment', 'exposer'));
    }

    public function addeditplayer()
    {
        $parentId = getCurrentUser();
        $user = $this->service->select();
        $view = 'SubAdmin.SubAdmin.AddEdit';
        return view('Admin', compact('view', 'user', 'parentId'));
    }

    public function addbalance(Request $request)
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
            'remark'          => 'Credited by Sub Admin ',
            'created_at'      => now(),
        ]);
        $walletUpdate = WalletTransactions::create([
            'user_id'         => $pUser->user_id,
            'tofrom_id'       => $request->user_id,
            'debit'          => $request->balance,
            'balance'          => $parent->balance,
            'remark'          => 'Debited by Sub Admin ',
            'created_at'      => now(),
        ]);
        $walletUpdate->save();

        return redirect()->back()->with('success', 'Balance transferred successfully.');
    }

    public function deletebalance(Request $request)
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
            'remark'          => 'Credited by Sub Admin',
            'created_at'      => now(),
        ]);
        $walletUpdate = WalletTransactions::create([
            'user_id'         => $pUser->user_id,
            'tofrom_id'       => $request->user_id,
            'credit'          => $request->balance,
            'balance'          => $parent->balance,
            'remark'          => 'Debited by Sub Admin',
            'created_at'      => now(),
        ]);
        $walletUpdate->save();

        return redirect()->back()->with('success', 'Balance transferred successfully.');
    }

    public function userPayment()
    {
        $user = $this->service->select();
        $puser = getCurrentUser();
        $view = 'SubAdmin.SubAdmin.PaymentPage';
        $payment = WalletTransactions::where('user_id', $puser->user_id)->get();
        return view('Admin', compact('view', 'user', 'payment'));
    }

    public function profileUpdatepage()
    {
        $user = getCurrentUser();
        $view = 'SubAdmin.SubAdmin.profileUpdatepage';
        return view('Admin', compact('view', 'user'));
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);

        // Toggle status
        $user->status = ($user->status === 'Active') ? 'Block' : 'Active';
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    public function jantriTablesa()
    {
        $tossGame = getPostsByPostType('optiongame', 0, 'new', true);
        $sattaGame = getPostsByPostType('numberGame', 0, 'new', true);
        $view = 'SubAdmin.Jantri.JantriView';
        return view('Admin', compact('view', 'tossGame', 'sattaGame'));
    }

    public function jantrisa(Request $request)
    {
        if ($request->tossGame == !NULL) {
            $game_id = $request->tossGame;
            $gameType = 'option';
            $c_user = getCurrentUser();

            $gameResult = GameResult::where('game_id', $game_id)->get('result')->first();

            $getgame = getPostsByPostType('optiongame', 0, 'new', true);
            $game = $getgame->where('post_id', $game_id)->first();

            $jantriData = BidTransaction::where('game_id', $game_id)
                ->where('parent_id', $c_user->user_id)
                ->selectRaw('answer, SUM(subadmin_amount) as total_bid, SUM(win_amount) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $view = 'SubAdmin.Jantri.Table';
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
            $c_user = getCurrentUser();
            $jantriData = BidTransaction::where('game_id', $game_id)
                ->where('parent_id', $c_user->user_id)
                ->where('updated_at', '>=', $timeLimit) // Only results updated in the last 5 hours
                ->where('updated_at', '<=', $selectedDateTime) // Ensure records match the selected date-time
                ->selectRaw('answer, SUM(subadmin_amount) as total_bid, SUM(win_amount) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $view = 'SubAdmin.Jantri.Table';
            return view('Admin', compact('view', 'jantriData', 'gameType', 'gameResult'));
        }

        return redirect()->back()->with('danger', 'No Jantri Found.');
    }
}
