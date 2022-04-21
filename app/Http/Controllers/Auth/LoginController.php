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
        // $this->middleware('guest')->except('logout');
    }


    public function showLoginForm(Request $request)
    {
        // echo $this->redirectTo;
        // exit;
        $viewData['pageTitle'] = "Login";
       
        if(\Session::get("login_to") == 'professional_panel'){
            return redirect("/login/professional");
        }
        if(isset($_GET['assessment']) && $_GET['assessment'] != ''){
             $url = url('assessment/u/'.$_GET['assessment']);
             \Session::put("redirect_back",$url);
        }elseif(isset($_GET['redirect_back']) && $_GET['redirect_back']){
            $url = $_GET['redirect_back'];
             \Session::put("redirect_back",$url);
        }
        else{
            $this->redirectTo = url()->previous();
        } 
        
        return view('auth.user-login',$viewData);
    }

    public function showSuperAdminLogin(Request $request)
    {
        // echo $this->redirectTo;
        // exit;
        $viewData['pageTitle'] = "Login";
       
        if(\Session::get("login_to") == 'professional_panel'){
            return redirect("/login/professional");
        }
        
        return view('auth.super-admin-login',$viewData);
    }


    public function loginAsUser(Request $request)
    {
        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password,'role'=>"user"]))
        {
           
            if(\Session::get('redirect_back')){
                $redirect = \Session::get('redirect_back');
                \Session::forget('redirect_back');
                return redirect($redirect);
            }
            else{
                 return redirect(baseUrl('/'));
            }
        }else{
            return redirect()->back()->with("error_message","Invalid Email or Password");
        }
       
    }

    public function loginAsSuperAdmin(Request $request)
    {
        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password,'role'=>"super_admin"]))
        {
            return redirect(baseUrl('/'));
        }else{
            return redirect()->back()->with("error_message","Invalid Email or Password");
        }
       
    }

    public function professionalLogin(Request $request)
    {
       
        if(\Session::get("login_to") != 'professional_panel'){
            return redirect("/login");
        }
        $viewData['pageTitle'] = "Login";

        if(isset($_GET['assessment']) && $_GET['assessment'] != ''){
             $url = url('assessment/u/'.$_GET['assessment']);
             \Session::put("redirect_back",$url);
        }elseif(isset($_GET['redirect_back']) && $_GET['redirect_back']){
            $url = $_GET['redirect_back'];
             \Session::put("redirect_back",$url);
        }
        else{
            $this->redirectTo = url()->previous();
        } 
        return view('auth.professional-login',$viewData);
    }

    public function loginAsProfessional(Request $request){

        // echo \Session::get("login_to");
        $databaseName = \DB::connection()->getDatabaseName();
  
        if(\Session::get("login_to") != 'professional_panel'){
            return redirect("/login");
        }
        // \Config::set('database.connections.mysql.database', 'immigrat_'.\Session::get("subdomain"));
        // \DB::purge('mysql');
        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect(baseUrl('/'));
        }else{
            return redirect()->back()->with("error_message","Invalid Email or Password");
        }
    }
    public function redirectTo()
    {
        return \Session::get('redirect_back') ? \Session::get('redirect_back') :   $this->redirectTo;
    }

}
