<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Illuminate\Support\Facades\Route;

use App\Models\DomainDetails;

class Admin
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
        
        if(\Session::get("login_to") != 'professional_panel'){
            return Redirect::to('/')->with("error","Invalid access");
        }
        $routeName = Route::currentRouteName();
        
        $allowed_routes = array("external-assessment","save-external-assessment");
        if(in_array($routeName,$allowed_routes)){
            return $next($request);
        }
        if(Auth::check()){
            if(Auth::user()->role == 'admin'){
                $setting = DomainDetails::first();
                if($setting->profile_status == 2){
                    return $next($request);
                }else{
                    if($request->ajax()){
                        $response['status'] = "error";
                        $response['message'] = "Not allowed to access this before profile approved";
                        return response()->json($response);
                    }else{
                        return Redirect::to(baseUrl('/complete-profile'));
                    }
                    
                }
            }else{
                return Redirect::to('/home');
            }
        }else{
            return Redirect::to('/professional/login');
        }
    }
}
