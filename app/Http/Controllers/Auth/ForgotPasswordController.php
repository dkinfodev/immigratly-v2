<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Providers\RouteServiceProvider;
use DB;
use View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function submitForgotPassword(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
  
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
  
             $mailData = array();
             $mailData['token'] = $token;
             $view = View::make('emails.forgotpassword',$mailData);
             
             $message = $view->render();
             $parameter['to'] = $request->email;
             $parameter['to_name'] = $request->email;
             $parameter['message'] = $message;
             $parameter['subject'] = "Reset Password Link";
             $parameter['view'] = "emails.forgotpassword";
             $parameter['data'] = $mailData;
             $mailRes = sendMail($parameter);

            return back()->with('message', 'We have e-mailed your password reset link!');
            
           return redirect('/forgot-password')->with('message', 'We have e-mailed your password reset link!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPassword($token) { 

         return view('auth.passwords.reset', ['token' => $token, 'pageTitle' => 'Reset Password']);
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPassword(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = \App\Models\User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect('/login')->with('message', 'Your password has been changed!');
      }

}
