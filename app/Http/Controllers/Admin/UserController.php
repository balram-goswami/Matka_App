<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session, DataTables, Redirect, DB, Validator, Form;
use App\Services\{
    UserService
};
use App\Models\{
    GameResult,
    BidTransaction,
    Wallet,
    WalletTransactions
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
        return redirect()->route('users.index');
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
            return redirect()->route('users.index');
        }
        $this->service->update($request, $user);
        Session::flash('success', "User Details update successfully.");
        return redirect()->route('users.index');
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
        $view = 'Admin.Results.ResultDashboard';
        return view('Admin', compact('view', 'user', 'numberGame'));
    }

    public function paymentRequest()
    {
        $user = $this->service->select();
        $view = 'Admin.Results.PaymentPage';
        $payment = WalletTransactions::all();
        return view('Admin', compact('view', 'user', 'payment'));
    }

    public function gameResult(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'game_id' => 'required',
                'result' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if result already declared for the game
        $games = GameResult::where('game_id', $request->game_id)->get();
        if ($games->isNotEmpty()) {
            return redirect()->back()->with('danger', 'Result Already Declared');
        }

        // Save the game result
        try {
            $results = new GameResult;
            $results->game_id = $request->game_id;
            $results->result = $request->result;
            $results->save();

            // Update the bid transactions
            BidTransaction::where('game_id', $request->game_id)
                ->where('bid_result', NULL)
                ->update([
                    'bid_result' => $request->result,
                    'winning_amount' => 'pending'
                ]);

            return redirect()->back()->with('success', 'Result Saved');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'An error occurred while saving the result');
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
            return redirect()->back()->with('error', 'Transaction not found or already processed.');
        }

        // Update the transaction status
        $pay->request_status = 'complete';
        $pay->save();

        // Find the associated wallet
        $wallet = Wallet::find($pay->wallet_id);

        if (!$wallet) {
            return redirect()->back()->with('error', 'Wallet not found.');
        }

        // Update the wallet balance
        $wallet->balance += $pay->deposit_amount; // Increment the balance
        $wallet->save();

        return redirect()->back()->with('success', 'Payment successfully confirmed.');
    }

    public function gameOptions(Request $request)
    {
        {
            $game = getPostsByPostType('optiongame', 0, 'new', true)->where('post_id', $request->game_id);
            
            foreach($game as $currentGame){
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
    }
}
