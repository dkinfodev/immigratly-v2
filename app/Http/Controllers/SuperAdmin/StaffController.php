<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\User;
use App\Models\Countries;
use App\Models\EmployeePrivileges;
use App\Models\EmployeePrivilegesActions;
use App\Models\StaffPrivileges;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Staff";
        $viewData['activeTab'] = "staff";
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
                        ->where("role","executive")
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
        $countries = Countries::get();
        //$languages = DB::table(MAIN_DATABASE.".languages")->get();
        //$roles = DB::table(MAIN_DATABASE.".roles")->get();
        //$viewData['languages'] = $languages;
        $viewData['countries'] = $countries;
        //$viewData['roles'] = $roles;
        $viewData['activeTab'] = "staff";
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
        
        $object = new User();
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->is_active = $request->input("status");
        $object->unique_id = randomNumber();
        $object->role = 'executive';

        if($request->input("password")){
            $object->password = bcrypt($request->input("password"));
        }
        
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = UserDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;
            }
        }
        
        $object->is_verified = 1;
        $object->created_by = \Auth::user()->id;
        $object->social_connect = 0;

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('staff');
        $response['message'] = "Record added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $id = base64_decode($id);
        $viewData['pageTitle'] = "Edit Staff";
        $record = User::where("id",$id)->first();
        $viewData['record'] = $record;
       
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        $viewData['activeTab'] = "staff";
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
        $object->is_active = $request->input("status");        
        $object->unique_id = randomNumber();
        $object->role = 'executive';
        
        if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            
            $destinationPath = UserDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;
            }
        }

        $object->is_verified = 1;
        $object->created_by = \Auth::user()->id;
        $object->social_connect = 0;

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
        $viewData['activeTab'] = "staff";
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

    public function setPrivileges($id){
        $id = base64_decode($id);
        $privileges = EmployeePrivileges::get();
        $staff_privileges = StaffPrivileges::where("user_id",$id)->get();

        $temp = array();
        foreach($staff_privileges as $value){
            $temp[$value->module][] = $value->action;
        }
        
        $viewData['staff_privileges'] = $temp;
        $user = User::find($id);
        $viewData['user'] = $user;
        $viewData['privileges'] = $privileges;
        $viewData['user_id'] = $id;
        $viewData['pageTitle'] = "Set Privileges for ".$user->first_name." ".$user->last_name;
        $viewData['activeTab'] = "staff";
        return view(roleFolder().'.staff.privileges',$viewData);
    }

    public function savePrivileges($id,Request $request){
        $id = base64_decode($id);

        StaffPrivileges::where('user_id',$id)->delete();
        if($request->input("privileges")){
            $privileges = $request->input("privileges");
            foreach($privileges as $module => $actions){
               for($i=0;$i < count($actions);$i++){
                    $object = new StaffPrivileges();
                    $object->user_id = $id;       
                    $object->module = $module;
                    $object->action = $actions[$i];
                    $object->save();
                }     
                
            }
            $response['status'] = true;
            $response['message'] = "Privileges added to roles";
        }else{
            $response['status'] = 'error';
            $response['message'] = 'No privileges selected';
        }
        return response()->json($response);
    }
    
}
