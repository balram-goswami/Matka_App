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
    Posts
};


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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = $this->service->table()->where('role', 'admin');
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
                           <a class="dropdown-item btn btn-info" href="' . route('users.edit', $row->user_id) . '"
                              ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                            ' . Form::open(array('route' => array('users.destroy', $row->user_id), 'method' => 'delete')) . '
                                <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                            </form>
                        </div>';
                })
                ->editColumn('created_at', function ($row) {
                    return dateFormat($row->created_at);
                })
                ->rawColumns(['action', 'created_at', 'photo'])
                ->make(true);
        }
        $view = 'Admin.Users.Index';
        return view('Admin', compact('view'));
    }

    public function customers(Request $request)
    {
        if ($request->ajax()) {
            $user = $this->service->table()->where('role', 'user');
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
                           <a class="dropdown-item btn btn-info" href="' . route('users.edit', $row->user_id) . '"
                              ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                            ' . Form::open(array('route' => array('users.destroy', $row->user_id), 'method' => 'delete')) . '
                                <button type="submit" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                            </form>
                        </div>';
                })
                ->editColumn('created_at', function ($row) {
                    return dateFormat($row->created_at);
                })
                ->rawColumns(['action', 'created_at', 'photo'])
                ->make(true);
        }
        $view = 'Admin.Users.Index';
        return view('Admin', compact('view'));
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
        $this->service->store($request);
        Session::flash('success', "New User saves successfully.");
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

        // Optimize game name retrieval
        $gameNames = Posts::whereIn('post_id', $results->pluck('id'))->pluck('post_title', 'post_id');

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
                if ($table->harf_digit === 'oddEven') {

                    $bidResult = ($request->result % 2 === 0) ? 'EVEN' : 'ODD';

                    BidTransaction::where('game_id', $request->game_id)
                        ->update([
                            'bid_result' => $request->result,
                            'result_status' => DB::raw("CASE WHEN answer = '$bidResult' THEN 'win' ELSE 'loss' END"),
                        ]);

                    return redirect()->back()->with('success', 'Bid result updated successfully');
                } elseif ($table->harf_digit === 'open') {
                    $firstDigit = intval(substr($request->result, 0, 1));

                    BidTransaction::where('game_id', $request->game_id)
                        ->update([
                            'bid_result' => $request->result,
                            'bid_result' => DB::raw("CASE WHEN answer = '$firstDigit' THEN 'win' ELSE 'loss' END"),
                        ]);
                } elseif ($table->harf_digit === 'close') {
                    $secondDigit = intval(substr($request->result, 1, 1));
                    dd($secondDigit);
                    BidTransaction::where('game_id', $request->game_id)
                        ->update([
                            'bid_result' => $request->result,
                            'bid_result' => DB::raw("CASE WHEN answer = '$secondDigit' THEN 'win' ELSE 'loss' END"),
                        ]);

                    return redirect()->back()->with('success', 'Bid results updated successfully');
                } else {
                    BidTransaction::where('game_id', $request->game_id)
                        ->update([
                            'bid_result' => $request->result,
                            'result_status' => DB::raw("CASE WHEN answer = '$request->result' THEN 'win' ELSE 'loss' END"),
                        ]);

                    return redirect()->back()->with('success', 'Result Saved');
                }
                return redirect()->back()->with('success', 'Result Saved');
            }
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
        // **Validate incoming request**
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

        // Find the associated wallet (user's wallet)
        $wallet = Wallet::findOrFail($request->wallet_id);

        // Check if the user has enough balance
        if ($wallet->balance < $pay->withdraw_amount) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance in user wallet.'])->withInput();
        }

        // If parent_id is provided, fetch the parent wallet
        $parent = $request->parent_id ? Wallet::where('user_id', $request->parent_id)->first() : null;

        // **Ensure sufficient balance in parent account (if applicable)**
        if ($parent && $parent->balance < $pay->withdraw_amount) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance in parent wallet.'])->withInput();
        }

        // **Begin Transaction**
        DB::transaction(function () use ($pay, $wallet, $parent, $request) {
            // Deduct from user's wallet
            $wallet->decrement('balance', $pay->withdraw_amount);

            // Deduct from parent wallet (if applicable)
            if ($parent) {
                $parent->increment('balance', $pay->withdraw_amount);
            }

            // Update the transaction status and details
            $pay->update([
                'request_status'    => 'complete',
                'transaction_type'  => $request->transaction_type,
                'utr_number'        => $request->utr_number,
            ]);
        });

        return redirect()->back()->with('success', 'Withdrawal request processed successfully.');
    }

    public function jantriTable()
    {
        $numberGame = getPostsByPostType('optiongame', 0, 'new', true);
        $sattaGame = getPostsByPostType('numberGame', 0, 'new', true);
        $games = $numberGame->merge($sattaGame);
        $gameIds = BidTransaction::select('game_id')->distinct()->pluck('game_id');

        $game_id = 1;

        // Fetch Jantri data for the selected game
        $jantriData = BidTransaction::where('game_id', $game_id)
            ->where('bid_result', NULL)
            ->selectRaw('answer as number, SUM(bid_amount) as total_amount')
            ->groupBy('answer')
            ->orderBy('answer', 'asc')
            ->get()
            ->keyBy('number');

        $view = 'Admin.Jantri.JantriView';
        return view('Admin', compact('view', 'games', 'jantriData'));
    }

    public function jantri(Request $request)
    {
        $game_id = $request->query('game_id', 1);

        // Fetch Jantri data for the selected game
        $jantriData = BidTransaction::where('game_id', $game_id)
            ->where('bid_result', NULL)
            ->selectRaw('answer as number, SUM(bid_amount) as total_amount')
            ->groupBy('answer')
            ->orderBy('answer', 'asc')
            ->get()
            ->keyBy('number'); // Key by answer (number) for lookup

        // Get unique game IDs for dropdown selection
        $numberGame = getPostsByPostType('optiongame', 0, 'new', true);
        $sattaGame = getPostsByPostType('numberGame', 0, 'new', true);
        $games = $numberGame->merge($sattaGame);

        $user = getCurrentUser();
        $subAdminWallet = Wallet::where('user_id', $user->user_id)->get()->first();
        

        $view = 'Admin.Jantri.JantriView';
        return view('Admin', compact('view', 'jantriData', 'games', 'game_id'));
    }
}
