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
        $users = User::where('parent', $pId->user_id)->paginate(25);
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

    public function chartSubAdmin()
    {
        $view = 'SubAdmin.SubAdmin.Chart';

        return view('Admin', compact('view'));
    }


    public function subadminAddUsers($id)
    {
        $user = User::where('user_id', $id)->first();
        $wallet = Wallet::where('user_id', $id)->first();
        $bids = BidTransaction::where('user_id', $id)->get();
        $win = BidTransaction::where('user_id', $id)->where('result_status', 'claimed')->get();
        $loss = BidTransaction::where('user_id', $id)->where('result_status', 'loss')->get();
        $panding = BidTransaction::where('user_id', $id)->where('result_status', NULL)->paginate(25);
        $payment = WalletTransactions::where('user_id', $id)->paginate(25);
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
                'delete_reason' => 'nullable',
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
            'remark'          => $request->delete_reason ?? 'Credited by Sub Admin ',
            'created_at'      => now(),
        ]);
        $walletUpdate = WalletTransactions::create([
            'user_id'         => $pUser->user_id,
            'tofrom_id'       => $request->user_id,
            'debit'          => $request->balance,
            'balance'          => $parent->balance,
            'remark'          => $request->delete_reason ?? 'Debited by Sub Admin ',
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
                'delete_reason' => 'nullable',
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
            'remark'          => $request->delete_reason ?? 'Credited by Sub Admin',
            'created_at'      => now(),
        ]);
        $walletUpdate = WalletTransactions::create([
            'user_id'         => $pUser->user_id,
            'tofrom_id'       => $request->user_id,
            'credit'          => $request->balance,
            'balance'          => $parent->balance,
            'remark'          => $request->delete_reason ?? 'Debited by Sub Admin',
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
        $payment = WalletTransactions::where('user_id', $puser->user_id)->paginate(25);
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
                ->selectRaw('answer, SUM(subadmin_dif) as total_bid, SUM(win_amount) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $view = 'SubAdmin.Jantri.Table';
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
                ->selectRaw('answer, SUM(subadmin_dif) as total_bid, SUM(win_amount) as total_win, result_status')
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

            $view = 'SubAdmin.Jantri.Table';
            return view('Admin', compact('view', 'jantriData', 'gameType', 'gameResult', 'jantriOddEven', 'jantriandar', 'jantribahar'));
        }

        return redirect()->back()->with('danger', 'No Jantri Found.');
    }
}
