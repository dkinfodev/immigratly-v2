<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;


class WebinarController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
       	$viewData['pageTitle'] = "Webinar";
      
        $viewData['status'] = 'publish';
        return view(roleFolder().'.webinar.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $subdomain = \Session::get("subdomain");
        $search = $request->input("search");
        $status = $request->input("status");
        $apiData['search'] = $search;
        $apiData['status'] = $status;
        if($request->get("page")){
            $page = $request->get("page");
        }else{
            $page = 1;
        }
        $result = curlRequest("webinar?page=".$page,$apiData);
        
        $records = array();
        if($result['status'] == 'success'){
            $data = $result['data'];
            $records = $data['data'];
            $response['last_page'] = $data['last_page'];
            $response['current_page'] = $data['current_page'];
            $response['total_records'] = $data['total'];
        }
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.webinar.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        
        return response()->json($response);
    }

    public function add(){

        $viewData['pageTitle'] = "Add Webinar";
        $services = DB::table(MAIN_DATABASE.".visa_services")->get();
        $viewData['services'] = $services;

        $tags = DB::table(MAIN_DATABASE.".tags")->get();
        $viewData['tags'] = $tags;

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $languages = DB::table(MAIN_DATABASE.".languages")->get();
        $roles = DB::table(MAIN_DATABASE.".roles")->get();
        $viewData['languages'] = $languages;
        $viewData['countries'] = $countries;

        $timestamp = time();
        $viewData['timestamp'] = $timestamp;
        return view(roleFolder().'.webinar.add',$viewData);
    }


    public function save(Request $request){
        
        $field_validate = array('title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'level'=>'required',
            'language_id'=>'required',
            'webinar_date'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'total_seats'=>'required|numeric');
        if($request->input("paid_event")){
            $field_validate['event_cost'] = "required";
            $field_validate['price_group'] = "required";
        }
        if($request->input("offline_event")){
            $field_validate['address'] = "required";
            $field_validate['country_id'] = "required";
            $field_validate['state_id'] = "required";
            $field_validate['city_id'] = "required";
        }else{
            $field_validate['online_event_link'] = "required";
        }
        $validator = Validator::make($request->all(),$field_validate);

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

        $apiData = $request->input();
        $apiData['added_by'] = \Auth::user()->unique_id;
        
        $result = curlRequest("webinar/save",$apiData);
        // pre($result);
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['redirect_back'] = baseUrl('webinar');
            $response['message'] = $result['message'];
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Some issue while saving article";

        }
        return response()->json($response);
    }
 
    public function edit($unique_id,Request $request){
        $viewData['pageTitle'] = "Edit Webinar";
        $services = DB::table(MAIN_DATABASE.".visa_services")->get();
        $viewData['services'] = $services;

        $tags = DB::table(MAIN_DATABASE.".tags")->get();
        $viewData['tags'] = $tags;

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $languages = DB::table(MAIN_DATABASE.".languages")->get();
        $roles = DB::table(MAIN_DATABASE.".roles")->get();
        $viewData['languages'] = $languages;
        $viewData['countries'] = $countries;
        $apiData['webinar_id'] = $unique_id;
        $result = curlRequest("webinar/fetch-webinar",$apiData);
        
        if($result['status'] == 'success'){
            $record = $result['data'];
            $states = DB::table(MAIN_DATABASE.".states")->where('country_id',$record['country_id'])->get();
            $cities = DB::table(MAIN_DATABASE.".cities")->where('state_id',$record['state_id'])->get();
            $viewData['states'] = $states;
            $viewData['cities'] = $cities;
            $viewData['record'] = $record;
        }else{
            return redirect()->back()->with("error","Webinar not found");
        }
        $timestamp = time();
        $viewData['timestamp'] = $timestamp;
        return view(roleFolder().'.webinar.edit',$viewData);
    }


    public function update($unique_id,Request $request){
        
        $field_validate = array('title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'level'=>'required',
            'language_id'=>'required',
            'webinar_date'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'total_seats'=>'required|numeric');
        if($request->input("paid_event")){
            $field_validate['event_cost'] = "required";
            $field_validate['price_group'] = "required";
        }
        if($request->input("offline_event")){
            $field_validate['address'] = "required";
            $field_validate['country_id'] = "required";
            $field_validate['state_id'] = "required";
            $field_validate['city_id'] = "required";
        }else{
            $field_validate['online_event_link'] = "required";
        }
        $validator = Validator::make($request->all(),$field_validate);


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

        $apiData = $request->input();
        $apiData['webinar_id'] = $unique_id;
        $apiData['added_by'] = \Auth::user()->unique_id;
        
        $result = curlRequest("webinar/update",$apiData);
        // pre($result);
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['redirect_back'] = baseUrl('webinar');
            $response['message'] = $result['message'];
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Some issue while saving article";

        }
        return response()->json($response);
    }
    public function deleteImage($id,Request $request){
       
        $apiData['webinar_id'] = $id;
        $apiData['image'] = $request->get("image");
        $result = curlRequest("webinar/delete-image",$apiData);
        
        if($result['status'] == 'success'){
            return redirect()->back()->with("success","Image has been deleted!");
        }else{
            return redirect()->back()->with("error","Image not deleted. Try again!");

        }
        
    }
    public function deleteSingle($id){       
        $apiData['webinar_id'] = $id;
        $result = curlRequest("webinar/delete",$apiData);

        if($result['status'] == 'success'){
            return redirect()->back()->with("success","Webinar has been deleted!");
        }else{
            return redirect()->back()->with("error","Some issue while deleting");
        }
    }
}
