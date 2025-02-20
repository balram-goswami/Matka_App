<?php
namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use DB;
use Session;
use Redirect;
use App\User;
use Illuminate\Support\Facades\Route;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if(!$user = JWTAuth::parseToken()->authenticate())
            {
                return Response()->json(['message' => 'unauthenticated'], 422);
            }else{                
                return $next($request); 
            }
        } catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            return Response()->json(['message' => 'unauthenticated'], 422);
        }
        return $next($request);
    }
}
