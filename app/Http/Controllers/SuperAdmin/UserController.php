<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\User;
use App\Models\Languages;
use App\Models\UserDetails;
use App\Models\Countries;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "User";
        $viewData['activeTab'] = "users";
        return view(roleFolder().'.user.lists',$viewData);
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
                        ->where("role","user")
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.user.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    
    public function add(){
        $viewData['pageTitle'] = "Add User";
        $countries = Countries::get();
        $viewData['countries'] = $countries;

        $viewData['languages'] = Languages::get();
        $viewData['activeTab'] = "users";
        return view(roleFolder().'.user.add',$viewData);
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
            'gender'=>'required',
            'date_of_birth'=>'required',
            'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
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
        $unique_id = randomNumber();
        $object2 = new UserDetails();
        $object->unique_id =  $unique_id;
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->is_active = $request->input("status");

        $object->role = 'user';

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

        $object2->user_id = $unique_id;
        $object2->date_of_birth = $request->input("date_of_birth");
        $object2->gender = $request->input("gender");
        $object2->country_id = $request->input("country_id");
        $object2->state_id = $request->input("state_id");
        $object2->city_id = $request->input("city_id");
        $object2->address = $request->input("address");
        $object2->zip_code = $request->input("zip_code");
        $object2->languages_known = json_encode($request->input("languages_known"));
        
        $object->save();
        $object2->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('user');
        $response['message'] = "User added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $id = base64_decode($id);
        $viewData['pageTitle'] = "Edit User";

        $record = User::where("id",$id)->first();
        $record2 = UserDetails::where("user_id",$record->unique_id)->first();

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;

        if(!empty($record2))
        {
            $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$record2->country_id)->get();
            $viewData['states'] = $states;
            $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$record2->state_id)->get();
            $viewData['cities'] = $cities;
        }


        $languages = Languages::get();
        $viewData['languages'] = $languages;

        $viewData['countries'] = $countries;

        $viewData['record'] = $record;
        $viewData['record2'] = $record2;
        
       
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        $viewData['activeTab'] = "users";
        return view(roleFolder().'.user.edit',$viewData);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  User::find($id);

        $username = $object->name;
        $object2 = UserDetails::where('user_id',$object->unique_id)->first();

        if(empty($object2))
        {
            $object2 = new UserDetails();
        }
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$object->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone_no' => 'required|unique:users,phone_no,'.$object->id,
            'gender'=>'required',
            'date_of_birth'=>'required',
            'languages_known'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
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
        $object->role = 'user';
        
         if ($file = $request->file('profile_image')){
                
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $path = userDir()."/profile";
            
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
            $destinationPath = userDir()."/profile";
            if($file->move($destinationPath, $newName)){
                $object->profile_image = $newName;                    
            }
        }

        $object2->date_of_birth = $request->input("date_of_birth");
        $object2->gender = $request->input("gender");
        $object2->country_id = $request->input("country_id");
        $object2->state_id = $request->input("state_id");
        $object2->city_id = $request->input("city_id");
        $object2->address = $request->input("address");
        $object2->zip_code = $request->input("zip_code");
        $object2->languages_known = json_encode($request->input("languages_known"));

        $object->is_verified = 1;
        //$object->created_by = \Auth::user()->id;
        $object->social_connect = 0;

        $object->save();
        $object2->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('user');
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
        $viewData['activeTab'] = "users";
        return view(roleFolder().'.user.change-password',$viewData);
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
        $response['redirect_back'] = baseUrl('user');
        $response['message'] = "Updation sucessfully";
        
        return response()->json($response);
    }
}
