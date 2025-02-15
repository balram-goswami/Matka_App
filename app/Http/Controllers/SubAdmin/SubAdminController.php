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
        $view = 'SubAdmin.SubAdmin.Index';
        Session::flash('password_change_alert', "Hello {$user->name}, please change your password before continuing to use your account. If done Ignore");
        return view('Admin', compact('view', 'wallet', 'players'));
    }

    public function viewPlayers()
    {
        $view = 'SubAdmin.SubAdmin.AddPlayers';
        return view('Admin', compact('view'));
    }

    public function subadminAddUsers($id)
    {
        $user = User::where('user_id', $id)->first();
        $wallet = Wallet::where('user_id', $id)->first();
        $bids = BidTransaction::where('user_id', $id)->get();
        $win = BidTransaction::where('user_id', $id)->where('result_status', 'claimed')->get();
        $loss = BidTransaction::where('user_id', $id)->where('result_status', 'loss')->get();
        $panding = BidTransaction::where('user_id', $id)->where('result_status', NULL)->get();
        $withdrawwallet = WalletTransactions::where('user_id', $id)->where('deposit_amount', NULL)->get();
        $dipositwallet = WalletTransactions::where('user_id', $id)->where('withdraw_amount', NULL)->get();

        $view = 'SubAdmin.SubAdmin.PlayerDetails';
        return view('Admin', compact('view', 'user', 'wallet', 'bids', 'win', 'loss', 'panding', 'withdrawwallet', 'dipositwallet'));
    }

    public function subadminplayers(Request $request)
    { {
            if ($request->ajax()) {
                $parent = getCurrentUser();
                $user = $this->service->table()->where('role', 'player')->where('parent', $parent->user_id);
                return Datatables::of($user)
                    ->addIndexColumn()
                    ->editColumn('photo', function ($row) {
                        if ($row->photo) {
                            return '<img src="' . asset($row->photo) . '" style="width:70px;" />';
                        }
                    })
                    ->addColumn('action', function ($row) {
                        return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                               <a class="btn btn-info" href="' . route('subadminAddUsers', $row->user_id) . '"
                                  ><i class="bx bx-edit-alt me-1"></i> Edit</a
                                  >
                                  
                                ' . Form::open(array('route' => array('users.destroy', $row->user_id), 'method' => 'delete')) . '
                                    <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                                </form>
                                <a class="btn btn-success" href="' . route('blockUser', $row->user_id) . '"
                                  ><i class="bx bx-edit-alt me-1"></i> Change Status</a>
                            </div>';
                    })
                    ->editColumn('created_at', function ($row) {
                        return dateFormat($row->created_at);
                    })
                    ->rawColumns(['action', 'created_at', 'photo'])
                    ->make(true);
            }
            $view = 'SubAdmin.SubAdmin.AddPlayers';
            return view('Admin', compact('view'));
        }
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
            return redirect()->back()->withErrors(['error' => 'Parent account not found'])->withInput();
        }

        if ($parent->balance < $request->balance) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance'])->withInput();
        }

        // Check if recipient account exists
        if (!$account) {
            return redirect()->back()->withErrors(['user_id' => 'Account not found'])->withInput();
        }

        // Deduct from parent's wallet
        $parent->balance -= $request->balance;
        $parent->save();

        // Add to recipient's wallet
        $account->balance += $request->balance;
        $account->save();

        $walletUpdate = WalletTransactions::create([
            'user_id'         => $request->user_id,   // Receiver ID
            'wallet_id'       => $account->id,       // Receiver Wallet ID
            'parent_id'       => $pUser->user_id,    // Sender (Parent) ID
            'deposit_amount'  => $request->balance,
            'transaction_type' => 'parent',           // Can be 'credit' or 'debit'
            'request_status'   => 'complete',        // Can be 'pending', 'completed', etc.
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
            return redirect()->back()->withErrors(['error' => 'Parent account not found'])->withInput();
        }

        if ($parent->balance < $request->balance) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance'])->withInput();
        }

        // Check if recipient account exists
        if (!$account) {
            return redirect()->back()->withErrors(['user_id' => 'Account not found'])->withInput();
        }

        // Deduct from parent's wallet
        $parent->balance += $request->balance;
        $parent->save();

        // Add to recipient's wallet
        $account->balance -= $request->balance;
        $account->save();

        $walletUpdate = WalletTransactions::create([
            'user_id'         => $request->user_id,   // Receiver ID
            'wallet_id'       => $account->id,       // Receiver Wallet ID
            'parent_id'       => $pUser->user_id,    // Sender (Parent) ID
            'withdraw_amount'  => $request->balance,
            'transaction_type' => 'parent',           // Can be 'credit' or 'debit'
            'request_status'   => 'complete',        // Can be 'pending', 'completed', etc.
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
        $payment = WalletTransactions::where('parent_id', $puser->user_id)->get();
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
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not found'])->withInput();
        }

        // Toggle status
        $user->status = ($user->status === 'active') ? 'block' : 'active';
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully');
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
                ->selectRaw('answer, SUM(admin_cut) as total_bid, SUM(win_amount + subadminget) as total_win, result_status')
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
                ->selectRaw('answer, SUM(admin_cut) as total_bid, SUM(win_amount + subadminget) as total_win, result_status')
                ->groupBy('answer', 'result_status')
                ->orderBy('answer', 'asc')
                ->get();

            $view = 'SubAdmin.Jantri.Table';
            return view('Admin', compact('view', 'jantriData', 'gameType', 'gameResult'));
        }

        return redirect()->back()->with('danger', 'No Jantri Found.');
    }
}
