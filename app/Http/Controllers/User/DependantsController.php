<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\UserDependants;

class DependantsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Dependants";
        return view(roleFolder().'.dependants.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = UserDependants::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("given_name","LIKE","%$search%");
                                $query->where("other_name","LIKE","%$search%");
                            }
                        })
                        ->where("user_id",\Auth::user()->unique_id)
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.dependants.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Dependant";
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        return view(roleFolder().'.dependants.add',$viewData);
    }


    public function save(Request $request){
        // pre($request->all());
        $validator = Validator::make($request->all(), [
            'given_name' => 'required',
            'family_name' => 'required',
            'date_of_birth' => 'required',
            'country_of_birth'=>'required',
            'city_of_birth'=>'required',
            'other_name'=>'required',
            'gender'=>'required'
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
        $object = new UserDependants();
        $object->unique_id = randomNumber();
        $object->given_name = $request->input("given_name");
        $object->family_name = $request->input("family_name");
        $object->other_name = $request->input("other_name");
        if($request->input("other_name") == 'yes'){
            $object->other_given_name = $request->input("other_given_name");
            $object->other_family_name = $request->input("other_family_name");
        }
        $object->date_of_birth = $request->input("date_of_birth");
        $object->country_of_birth = $request->input("country_of_birth");
        $object->city_of_birth = $request->input("city_of_birth");
        $object->gender = $request->input("gender");
        if($request->input("passport_number")){
            $object->passport_number = $request->input("passport_number");
        }
        if($request->input("passport_country")){
            $object->passport_country = $request->input("passport_country");
        }
        if($request->input("issue_date")){
            $object->issue_date = $request->input("issue_date");
        }
        if($request->input("expiry_date")){
            $object->expiry_date = $request->input("expiry_date");
        }
        if($request->input("primary_phone_no")){
            $object->primary_phone_no = $request->input("primary_phone_no");
        }
        if($request->input("secondary_phone_no")){
            $object->secondary_phone_no = $request->input("secondary_phone_no");
        }
        if($request->input("business_phone_no")){
            $object->business_phone_no = $request->input("business_phone_no");
        }
        $object->user_id = \Auth::user()->unique_id;
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('dependants');
        $response['message'] = "Dependant added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $viewData['pageTitle'] = "Edit Dependant";
        $record = UserDependants::where("unique_id",$id)->first();
        $viewData['record'] = $record;
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        
        $viewData['countries'] = $countries;
    
        return view(roleFolder().'.dependants.edit',$viewData);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  UserDependants::find($id);

        $validator = Validator::make($request->all(), [
            'given_name' => 'required',
            'family_name' => 'required',
            'date_of_birth' => 'required',
            'country_of_birth'=>'required',
            'city_of_birth'=>'required',
            'other_name'=>'required',
            'gender'=>'required'
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
        $object->given_name = $request->input("given_name");
        $object->family_name = $request->input("family_name");
        $object->other_name = $request->input("other_name");
        if($request->input("other_name") == 'yes'){
            $object->other_given_name = $request->input("other_given_name");
            $object->other_family_name = $request->input("other_family_name");
        }
        $object->date_of_birth = $request->input("date_of_birth");
        $object->country_of_birth = $request->input("country_of_birth");
        $object->city_of_birth = $request->input("city_of_birth");
        $object->gender = $request->input("gender");
        if($request->input("passport_number")){
            $object->passport_number = $request->input("passport_number");
        }
        if($request->input("passport_country")){
            $object->passport_country = $request->input("passport_country");
        }
        if($request->input("issue_date")){
            $object->issue_date = $request->input("issue_date");
        }
        if($request->input("expiry_date")){
            $object->expiry_date = $request->input("expiry_date");
        }
        if($request->input("primary_phone_no")){
            $object->primary_phone_no = $request->input("primary_phone_no");
        }
        if($request->input("secondary_phone_no")){
            $object->secondary_phone_no = $request->input("secondary_phone_no");
        }
        if($request->input("business_phone_no")){
            $object->business_phone_no = $request->input("business_phone_no");
        }
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('dependants');
        $response['message'] = "Depandatn update sucessfully";
        
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
        return view(roleFolder().'.dependants.change-password',$viewData);
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
