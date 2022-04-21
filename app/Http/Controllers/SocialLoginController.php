<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\Models\User;
use App\Models\UserDetails;

class SocialLoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function Callback($provider){
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();

        if($users){
            if($users->role == 'user'){
                Auth::loginUsingId($users->id);
                if(\Session::get('redirect_back')){
                    $redirect = \Session::get('redirect_back');
                    \Session::forget('redirect_back');
                    return redirect($redirect);
                }
                else{
                     return redirect(baseUrl('/'));
                }
            }else{
                return redirect('/login')->with("error_message","Your account is registered as ".$users->role.". Please try to login with your credentails or contact the support team"); 
            }
        }else{
            $name = explode(" ",$userSocial->getName());
            $last_name = '';
            $first_name = '';
            if(isset($name[0])){
                $first_name = $name[0];
            }
            if(isset($name[1])){
                $last_name = $name[1];
            }
            $unique_id = randomNumber();
            $user = User::create([
                'unique_id'     => $unique_id,
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'email'         => $userSocial->getEmail(),
                'password'      => bcrypt('demo@123'),
                'profile_image' => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
                'is_active'     => 1,
                'is_verified'   => 1,
                'role'          =>'user'
            ]);   
            Auth::login($user);
            $object = new UserDetails();
            $object->user_id = $unique_id;
            $object->save();
            // return redirect('/home');
            if(\Session::get('redirect_back')){
                $redirect = \Session::get('redirect_back');
                \Session::forget('redirect_back');
                return redirect($redirect);
            }
            else{
                 return redirect(baseUrl('/'));
            }
        }
    }

    public function googleCallback(Request $request){
        $query = $request->all();
        $qs = array();
        foreach ($query as $key => $value) {
            $qs[] ="$key=".$value;
        }
        $qs = implode("&",$qs);

        $cookies = $_COOKIE;
        
        $url = '';
        foreach($cookies as $key =>$value){
            if(strpos($key,"google_url") !== false){
                $url = $value;
                $url .="?".$qs;
            }
        }
        if($url != ''){
            return redirect($url);
        }else{
            echo "Redirection failed, try again";
        }   
    }

    public function dropboxCallback(Request $request){
        $query = $request->all();
        $qs = array();
        foreach ($query as $key => $value) {
            $qs[] ="$key=".$value;
        }
        $qs = implode("&",$qs);

        $cookies = $_COOKIE;
        
        $url = '';
        
        foreach($cookies as $key =>$value){
            if(strpos($key,"dropbox_url") !== false){
                $url = $value;
                $url .="?".$qs;
            }
        }
        if($url != ''){
            return redirect($url);
        }else{
            echo "Redirection failed, try again";
        }   
    }
}
