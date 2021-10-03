<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\User;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Staff";
        return view(roleFolder().'.staff.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = User::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("first_name","LIKE","%$search%");
                            }
                        })
                        ->where("role","!=","admin")
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.staff.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Staff";
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $languages = DB::table(MAIN_DATABASE.".languages")->get();
        $roles = DB::table(MAIN_DATABASE.".roles")->get();
        $viewData['languages'] = $languages;
        $viewData['countries'] = $countries;
        $viewData['roles'] = $roles;
        return view(roleFolder().'.staff.add',$viewData);
    }


    public function save(Request $request){
        // pre($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no',
            'gender'=>'required',
            'date_of_birth'=>'required',
            // 'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
            'role'=>'required',
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4',
            'profile_image'=>'mimes:jpeg,jpg,png,gif'
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
        $id = \Auth::user()->id;
        $object = new User();
        $object->unique_id = randomNumber();
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->date_of_birth = $request->input("date_of_birth");
        $object->gender = $request->input("gender");
        $object->country_id = $request->input("country_id");
        $object->state_id = $request->input("state_id");
        $object->city_id = $request->input("city_id");
        $object->address = $request->input("address");
        $object->zip_code = $request->input("zip_code");
        
        if($request->input("password")){
            $object->password = bcrypt($request->input("password"));
        }

        $object->role = $request->input("role");
        $object->languages_known = json_encode($request->input("languages_known"));
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $path = professionalDir()."/profile";
            
            $destinationPath = $path.'/thumb';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 100,100,80);

            $destinationPath = $path.'/medium';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 500,500,80);

            $destinationPath = professionalDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;
            }
        }

        $object->is_active = 1;
        $object->is_verified = 1;
        $object->created_by = \Auth::user()->id;

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('staff');
        $response['message'] = "User added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $id = base64_decode($id);
        $viewData['pageTitle'] = "Edit Staff";
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$record->country_id)->get();
        $viewData['states'] = $states;
        $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$record->state_id)->get();
        $viewData['cities'] = $cities;

        $languages = DB::table(MAIN_DATABASE.".languages")->get();
        $viewData['languages'] = $languages;
        
        $viewData['countries'] = $countries;
    
        $roles = DB::table(MAIN_DATABASE.".roles")->get();
        $viewData['roles'] = $roles;
        
        return view(roleFolder().'.staff.edit',$viewData);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  User::find($id);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$object->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no,'.$object->id,
            'gender'=>'required',
            'date_of_birth'=>'required',
            // 'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
            'role'=>'required',
            'profile_image'=>'mimes:jpeg,jpg,png,gif'
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
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->date_of_birth = $request->input("date_of_birth");
        $object->gender = $request->input("gender");
        $object->country_id = $request->input("country_id");
        $object->state_id = $request->input("state_id");
        $object->city_id = $request->input("city_id");
        $object->address = $request->input("address");
        $object->zip_code = $request->input("zip_code");
        
        $object->role = $request->input("role");
        $path = professionalDir()."/profile";
        $object->languages_known = json_encode($request->input("languages_known"));
        if($object->profile_image !=''){
            if(file_exists($path.'/'.$object->profile_image))
                unlink($path.'/'.$object->profile_image);

            if(file_exists($path.'/thumb/'.$object->profile_image))
                unlink($path.'/thumb/'.$object->profile_image);

            if(file_exists($path.'/medium/'.$object->profile_image))
                unlink($path.'/medium/'.$object->profile_image);
        }
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            // Thumb Image
            
            $destinationPath = $path.'/thumb';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 100,100,80);

            $destinationPath = $path.'/medium';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $destination_url = $destinationPath.'/'.$newName;
            resizeImage($source_url, $destination_url, 500,500,80);

            $destinationPath = professionalDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;
            }
        }

        $object->is_active = 1;
        $object->is_verified = 1;
        $object->created_by = \Auth::user()->id;

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('staff');
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        User::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            User::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }


    public function changePassword($id)
    {
        $id = base64_decode($id);
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Change Password";
        return view(roleFolder().'.staff.change-password',$viewData);
    }

    public function updatePassword($id,Request $request)
    {
        $id = base64_decode($id);
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
        $response['redirect_back'] = baseUrl('staff');
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }

}
