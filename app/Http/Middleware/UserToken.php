<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use DB;
use Session;
use Redirect;
use App\User;
use Illuminate\Support\Facades\Route;


class UserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        try {
            if(!$user = JWTAuth::parseToken()->authenticate())
            {
                return response()->json(['message' => 'Your Session has been expired, Please login again.'], 401);
            }else{                
                return $next($request); 
            }
        } catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            return response()->json(['message' => 'Your Session has been expired, Please login again.'], 401);
        }
        return $next($request);
    }
}
