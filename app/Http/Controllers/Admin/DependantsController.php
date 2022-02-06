<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('admin');
    }

    public function index($client_id)
    {
        $client = DB::table(MAIN_DATABASE.".users")->where("unique_id",$client_id)->first();
        $viewData['pageTitle'] = "Dependants of ".$client->first_name." ".$client->last_name;
        $viewData['client_id'] = $client_id;
        $viewData['activeTab'] = 'dependants';
        return view(roleFolder().'.dependants.lists',$viewData);
    } 

    public function getAjaxList($client_id,Request $request)
    {
        $search = $request->input("search");
        $records = DB::table(MAIN_DATABASE.".user_dependants")
                        ->orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("given_name","LIKE","%$search%");
                                $query->where("other_name","LIKE","%$search%");
                            }
                        })
                        ->where("user_id",$client_id)
                        ->paginate();
        $viewData['records'] = $records;
        $viewData['client_id'] = $client_id;
        $view = View::make(roleFolder().'.dependants.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add($client_id){
        $viewData['pageTitle'] = "Add Dependant";
        $viewData['client_id'] = $client_id;
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $viewData['activeTab'] = 'dependants';
        return view(roleFolder().'.dependants.add',$viewData);
    }


    public function save($client_id,Request $request){
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
        
        $insData['unique_id'] = randomNumber();
        $insData['given_name'] = $request->input("given_name");
        $insData['family_name'] = $request->input("family_name");
        $insData['other_name'] = $request->input("other_name");
        if($request->input("other_name") == 'yes'){
            $insData['other_given_name'] = $request->input("other_given_name");
            $insData['other_family_name'] = $request->input("other_family_name");
        }
        $insData['date_of_birth'] = $request->input("date_of_birth");
        $insData['country_of_birth'] = $request->input("country_of_birth");
        $insData['city_of_birth'] = $request->input("city_of_birth");
        $insData['gender'] = $request->input("gender");
        if($request->input("passport_number")){
            $insData['passport_number'] = $request->input("passport_number");
        }
        if($request->input("passport_country")){
            $insData['passport_country'] = $request->input("passport_country");
        }
        if($request->input("issue_date")){
            $insData['issue_date'] = $request->input("issue_date");
        }
        if($request->input("expiry_date")){
            $insData['expiry_date'] = $request->input("expiry_date");
        }
        if($request->input("primary_phone_no")){
            $insData['primary_phone_no'] = $request->input("primary_phone_no");
        }
        if($request->input("secondary_phone_no")){
            $insData['secondary_phone_no'] = $request->input("secondary_phone_no");
        }
        if($request->input("business_phone_no")){
            $insData['business_phone_no'] = $request->input("business_phone_no");
        }
        $insData['user_id'] = $client_id;
        $insData['is_approved'] = 0;

        DB::table(MAIN_DATABASE.".user_dependants")->insert($insData);
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('leads/dependants/'.$client_id);
        $response['message'] = "Dependant added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $viewData['pageTitle'] = "Edit Dependant";
        $record = UserDependants::where("unique_id",$id)->first();
        $viewData['record'] = $record;
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        
        $viewData['countries'] = $countries;
        $viewData['activeTab'] = 'dependants';
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
        UserDependants::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            UserDependants::deleteRecord($id);
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
        $viewData['activeTab'] = 'dependants';
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
