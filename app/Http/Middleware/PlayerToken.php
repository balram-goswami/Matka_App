<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use DB;
use Session;
use Redirect;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Route;

class PlayerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if(!$user = Auth::user())
            {
                Session::flash ( 'warning', "Your Session has been expired, Please login again." );
                return redirect()->route('login.index');
            }else{ 

                if ($user->role != User::PLAYER) {
                    Session::flash ( 'warning', "You are not authorized to access this url, Please login again." );
                    return redirect()->route('login.index');
                }               
                return $next($request); 
            }
        } catch(Exception $e){
            Session::flash ( 'warning', "Your Session has been expired, Please login again." );
            return redirect()->route('login.index');
        }
        return $next($request);
    }
}
