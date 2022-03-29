<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm(Request $request)
    {
        // echo $this->redirectTo;
        // exit;
        $viewData['pageTitle'] = "Login";

        if(isset($_GET['assessment']) && $_GET['assessment'] != ''){
             $url = url('assessment/u/'.$_GET['assessment']);
             \Session::put("redirect_back",$url);
        }else{
            $this->redirectTo = url()->previous();
        } 
        return view('auth.login',$viewData);
    }

    public function redirectTo()
    {
        return \Session::get('redirect_back') ? \Session::get('redirect_back') :   $this->redirectTo;
    }

}
