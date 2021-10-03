<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Models\Notifications;
use App\Models\NotificationRead;

class CommonController extends Controller
{
   	public function __construct()
    {

    }

    public function stateList(Request $request){
    	$country_id = $request->input("country_id");
    	$states = DB::table(MAIN_DATABASE.".states")->where("country_id",$country_id)->get();
    	$options = '<option value="">Select State</option>';
    	foreach($states as $state){
    		$options .= '<option value="'.$state->id.'">'.$state->name.'</option>';
    	}
    	$response['options'] = $options;
    	$response['status'] = true;
    	return response()->json($response);
    }

    public function cityList(Request $request){
    	$state_id = $request->input("state_id");
    	$cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$state_id)->get();
    	$options = '<option value="">Select City</option>';
    	foreach($cities as $city){
    		$options .= '<option value="'.$city->id.'">'.$city->name.'</option>';
    	}
    	$response['options'] = $options;
    	$response['status'] = true;
    	return response()->json($response);
    }

    public function licenceBodies(Request $request){
    	$country_id = $request->input("country_id");
    	$licence_bodies = DB::table(MAIN_DATABASE.".licence_bodies")->where("country_id",$country_id)->get();
    	$options = '<option value="">Select License Body</option>';
    	foreach($licence_bodies as $bodies){
    		$options .= '<option value="'.$bodies->id.'">'.$bodies->name.'</option>';
    	}
    	$response['options'] = $options;
    	$response['status'] = true;
    	return response()->json($response);
    }

    public function readNotification($id){
        if(\Auth::check()){
            $id = base64_decode($id);
            $notification = Notifications::where("id",$id)->first();
            $is_read = $notification->NotificationRead($id);
            if($is_read <= 0){
                $object = new NotificationRead();
                $object->notification_id = $id;
                $object->user_id = \Auth::user()->unique_id;
                $object->user_role = \Auth::user()->role;
                $object->save();
            }
            if($notification->url != ''){
                return redirect(baseUrl($notification->url));
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back()->with("error","Not allowed to view");
        }
    }

    public function uploadFiles(Request $request){
        $timestamp = $request->get("timestamp");
        
        if ($file = $request->file('file'))
        {
            $fileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $newName = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = public_path('/uploads/temp/'.$timestamp);
            if($file->move($destinationPath, $newName)){
                $response['status'] = true;
                $response['message'] = 'File uploaded successfully';
            }else{
                $response['status'] = false;
                $response['message'] = 'Select profile image';
            }

            return response()->json($response);
        }
    }
}
