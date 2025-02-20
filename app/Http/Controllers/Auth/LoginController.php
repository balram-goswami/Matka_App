<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Auth, Session, Redirect, Validator};
use App\Services\{UserService};

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('Auth.Login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('warning', $validator->getMessageBag()->first());
            return Redirect::back();
        }
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials, true)) {
            Session::flash('success', "Login Successfully");
            $currentUser = getCurrentUser();
            if ($currentUser->role === User::USER) {
                return redirect()->route('dashboard.index');
            } else if ($currentUser->role === User::SUBADMIN) {
                return redirect()->route('subadminDashboard');
            } else if ($currentUser->role === User::PLAYER) {
                return redirect()->route('playerDashboard');
            } else{
                return redirect()->route('dashboard.index');
            }
        } else {
            Session::flash('warning', "Invalid Credentials , Please try again.");
            return Redirect::back();
        }
    }
    public function logout()
    {
        Auth::logout();
        Session::flash('warning', "Logout Successfully");
        return redirect()->route('login.index');
    }
    public function forgotPassword()
    {
        return view('Auth.ForgotPassword');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPasswordSend(Request $request)
    {
        if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            Session::flash('warning', 'The email must be a valid email address.');
            return Redirect::back();
        }
        $user = User::where('email', $request->input('email'))->get()->first();
        if (!$user) {
            Session::flash('warning', 'Account does not exist in our system.');
            return Redirect::back();
        }

        $password = rand(000000000, 999999999);
        $user->password = bcrypt($password);
        $user->save();
        return Redirect::back();
    }

    public function registerpage()
    {
        return view('Auth.Register');
    }

    public function registernow(Request $request)
    {
        $this->userService->store($request); 
        $user = $this->userService->getUserByEmail($request->input('email'));
        Auth::login($user);
        Session::flash ( 'success', "New User saves successfully." );
        return redirect()->route('user-dashboard')->with('success', 'Registration successful!');
    }
}
