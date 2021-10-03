<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Illuminate\Support\Facades\Route;

class User
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
        if(Auth::check()){
            refresh_google_token();
            if(Auth::user()->role == 'user'){
                $routeName = Route::currentRouteName();
                $allowed_routes = array("user-edit-profile","user-update-profile");
                
                if(Auth::user()->is_active == 0){
                    Auth::logout();
                    return Redirect::to('/login')->with("error_message","Your account is not inactive. Please contact the support team");
                }
                if(Auth::user()->is_verified == 0){
                    Auth::logout();
                    return Redirect::to('/login')->with("error_message","Your account is not verified yet. Check your email or contact the support team");
                }
                
                if(!in_array($routeName,$allowed_routes)){
                    if(Auth::user()->UserDetail->profile_complete == 0){
                        return Redirect::to(baseUrl('/complete-profile'))->with("error_message","Please complete your profile before using the system");
                    }
                }
                return $next($request);
            }
            else{
                return Redirect::to('/home');
            }
        }else{
            return Redirect::to('/login');
        }
    }
}
