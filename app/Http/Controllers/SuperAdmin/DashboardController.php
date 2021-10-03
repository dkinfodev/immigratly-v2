<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Countries;
use App\Models\User;

class DashboardController extends Controller
{
    var $dropdown;
    public function __construct()
    {
        $this->middleware('super_admin');
    }
    public function dashboard()
    {
        $viewData['pageTitle'] = "Dashboard";
        return view(roleFolder().'.dashboard',$viewData);
    }

    public function editProfile()
    {
        $viewData['pageTitle'] = "Edit Profile";
        
        $countries = Countries::get();
        $viewData['countries'] = $countries;

        $user = User::where("id",\Auth::user()->id)->first();
        $viewData['user'] = $user;
        
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        return view(roleFolder().'.edit-profile',$viewData);
    }

    public function updateProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            //'password' => 'required|confirmed|min:6',
            'country_code' => 'required',
            'phone_no' => 'required',
            // 'verification_code'=>'required',
        ]);
        
       // session(['redirect_back' => $request->input('redirect_back')]);
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        
        $id = \Auth::user()->id;
        
        $object =  User::find($id);
        $profile_image = $object->profile_image;
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        if($request->input("password")){
            $object->password = bcrypt($request->input("password"));
        }
        $object->phone_no = $request->input("phone_no");
        $object->country_code = $request->input("country_code");

        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $path = superAdminDir()."/profile";
            
            $destinationPath = $path.'/thumb';
            if (file_exists($destinationPath."/".$profile_image)) {
                unlink($destinationPath."/".$profile_image);
            }
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 100,100,80);

            $destinationPath = $path.'/medium';
            if (file_exists($destinationPath."/".$profile_image)) {
                unlink($destinationPath."/".$profile_image);
            }
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 500,500,80);
            $destinationPath = superAdminDir()."/profile";
            if (file_exists($destinationPath."/".$profile_image)) {
                unlink($destinationPath."/".$profile_image);
            }
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;                    
            }
        }
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/edit-profile');
        $response['message'] = "Profile updated successfully";
        
        return response()->json($response);

    }

    public function changePassword()
    {
        $id = \Auth::user()->id;
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Change Password";
        return view(roleFolder().'.change-password',$viewData);
    }

    public function updatePassword(Request $request)
    {
        $id = \Auth::user()->id;
        $object =  User::find($id);

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        
        if($request->input("password")){
            $object->password = bcrypt($request->input("password"));
        }

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/');
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }
}
