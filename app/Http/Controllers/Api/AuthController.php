<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;
use JWTAuth;
use App\Models\{
    User,
};
use App\Services\CommunicationService;

class AuthController extends Controller
{
    protected $communicationService;
    public function __construct(CommunicationService $communicationService) {
        $this->communicationService = $communicationService;
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginRules() {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), self::loginRules($request));
        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()->first()], 422);        
        }
        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
        {
            return response()->json(['message' => "The email must be a valid email address."], 422);
        }

        $credentials = $request->only('email', 'password');
        if ($token = JWTAuth::attempt($credentials)) {
            return $this->createNewToken($token);
        } else {
            return response()->json(['message' => "Oppes! You have entered invalid credentials." ], 422);
        }
    }

    public function registerRules() {
        return [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            // 'phone' => 'required|unique:users|max:15',
            'password' => 'required|min:6',
        ];
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), self::registerRules($request));
        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()->first()], 422);        
        }
        if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
        {
            return response()->json(['message' => "The email must be a valid email address."], 422);
        }

        $email = $request->input('email');
        $randomPassword = sha1(mt_rand(10000,99999).time().$email);
        $password = $request->input('password')??$randomPassword;

        $user = new User();
        if ($request->file('photo')) {
            $user->photo = fileuploadExtra($request, 'photo');
        }        
        $user->name = $request->input('name');
        $user->business_name = $request->input('business_name');
        $user->email = $email;
        $user->phone = $request->input('phone');
        if ($password) {
            $user->password = bcrypt($password);
        }        
        $user->role = 'user';
        $user->email_verified_at = DateTime();
        $user->save();

        $name = $request->input('name');
        $emailSubject = 'Login details at '.appName();
        $emailBody = view('Email.RegisterVerifyEmailLink', compact('name', 'password', 'email'));
        $this->communicationService->mail($email, $emailSubject, $emailBody);
        return response()->json(['message' => "Account created successfully.", 'user' => $user], 201);
    }

    public function refreshToken(){
        $token = JWTAuth::getToken();
        if(!$token){
            return response()->json(['message' => "Token not provided."], 422);
        }
        try{
            $token = JWTAuth::refresh($token);
        }catch(TokenInvalidException $e){
            return response()->json(['message' => "The token is invalid."], 422);
            throw new AccessDeniedHttpException('The token is invalid');
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        Session::flush ();
        Auth::logout ();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        $user = auth()->user(); 
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user
        ]);
    }
    public function resetPassword(Request $request){
       if(!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
        return Response()->json(['message' => 'The email must be a valid email address.' ],422);
       }
       $user = User::where('email', $request->input('email'))->get()->first();
       if(!$user){
        return Response()->json(['message' => 'Account does not exist in our system.' ],422);
       }
       
       $password = str_random(8);
       $user->password = bcrypt($password);
       $user->save();

       $name = $user->name;
       $email = $user->email;
       $username = $user->username;
       $emailSubject = 'Forgot Password - '.appName();
       $emailBody = view('Email.ForgotPasswordEmail', compact('name', 'password', 'email', 'username'));
       
       $this->communicationService->mail($email, $emailSubject, $emailBody, [], '', '', '', '');
       return Response()->json(['message' => 'Reset password has been sent to your email.' ],200);
    }
}