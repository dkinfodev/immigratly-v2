<?php

namespace App\Http\Controllers\Associate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;

use App\Models\Cases;
use App\Models\Leads;
use App\Models\ProfessionalServices;
class LeadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('associate');
    }

    public function newLeads(Request $request){
        if(!role_permission('leads','view-leads')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $viewData['total_leads'] = Leads::count();
        $viewData['new_leads'] =  Leads::where('mark_as_client','0')->count();
        $viewData['lead_as_client'] =  Leads::where('mark_as_client','1')->count();
       	$viewData['pageTitle'] = "New Leads";
        $viewData['activeTab'] = "leads";
        return view(roleFolder().'.leads.lists',$viewData);
    }

    public function getNewList(Request $request)
    {
        if(!role_permission('leads','view-leads')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $search = $request->input("search");
        $records = Leads::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("first_name","LIKE","%$search%");
                                $query->orWhere("last_name","LIKE","%$search%");
                                $query->orWhere("email","LIKE","%$search%");
                                $query->orWhere(DB::raw('concat(country_code,"",phone_no)') , 'LIKE' , "%$search%");
                            }
                        })
                        ->where("mark_as_client","0")
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.leads.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function quickLead(Request $request){
        if(!role_permission('leads','quick-lead')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $viewData['pageTitle'] = "Quick Lead";
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
       
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $view = View::make(roleFolder().'.leads.modal.quick-lead',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function createQuickLead(Request $request){
        if(!role_permission('leads','quick-lead')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:leads',
            'country_code' => 'required',
            'phone_no' => 'required|unique:leads',
            'visa_service_id'=>'required',
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

        $object = new Leads();
        $object->unique_id = randomNumber();
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Lead added successfully";
        return response()->json($response);
    }

    public function deleteSingle($id,Request $request){
        if(!role_permission('leads','delete-lead')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $id = base64_decode($id);
        Leads::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        if(!role_permission('leads','delete-lead')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Leads::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function edit($id,Request $request){
        if(!role_permission('leads','edit-lead')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $id = base64_decode($id);
        $record = Leads::find($id);
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Lead";
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $states = DB::table(MAIN_DATABASE.".states")->where("country_id",$record->country_id)->get();
        $viewData['states'] = $states;
        $cities = DB::table(MAIN_DATABASE.".cities")->where("state_id",$record->state_id)->get();
        $viewData['cities'] = $cities;
        return view(roleFolder().'.leads.edit',$viewData);
    }

    public function update($id,Request $request){
        if(!role_permission('leads','edit-lead')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $id = base64_decode($id);
        $object = Leads::find($id);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:leads,email,'.$object->id,
            'country_code' => 'required',
            'phone_no' => 'required|unique:leads,phone_no,'.$object->id,
            'gender' => 'required',
            'date_of_birth' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'visa_service_id'=>'required',
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
        $object->visa_service_id = $request->input("visa_service_id");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Lead edited successfully";
        $response['redirect_back'] = baseUrl('leads');
        return response()->json($response);
    }

    public function markAsClient($id,Request $request){
        if(!role_permission('leads','mark-as-client')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $viewData['pageTitle'] = "Mark as client";
        $lead_id = base64_decode($id);
        $viewData['lead_id'] = $lead_id;
        $lead = Leads::find($lead_id);
        $viewData['lead'] = $lead;
        $view = View::make(roleFolder().'.leads.modal.mark-as-client',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }
    
    public function confirmAsClient($id,Request $request){
        if(!role_permission('leads','mark-as-client')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        $validator = Validator::make($request->all(), [
            'case_title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $response['error_type'] = 'validation';
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $id = base64_decode($id);
        $lead = Leads::select('first_name','last_name','email','country_code','phone_no','date_of_birth','gender','country_id','state_id','city_id','address','zip_code')->where("id",$id)->first();
        $postData['data'] = $lead;
        $result = curlRequest("create-client",$postData);
       
        if($result['status'] == 'error'){
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = $result['message'];
        }elseif($result['status'] == 'success'){
            $object = Leads::find($id);
            $visa_service_id = $object->visa_service_id;
            $object->mark_as_client = 1;
            $object->master_id = $result['user_id'];
            $object->save();

            $object2 = new Cases();
            $object2->unique_id = randomNumber();
            $object2->client_id = $result['user_id'];
            $object2->case_title = $request->input("case_title");
            $object2->start_date = $request->input("start_date");
            $object2->end_date = $request->input("end_date");
            $object2->visa_service_id = $visa_service_id;
            $object2->created_by = \Auth::user()->id;
            $object2->save();

            $response['status'] = true;
            $response['message'] = "Lead is converted to client and case of client is created!";
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Issue while marking lead as client";
        }
        return response()->json($response);
    }

}
