<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;

use App\Models\Cases;
use App\Models\Leads;
use App\Models\AssignLeads;
use App\Models\ProfessionalServices;
use App\Models\User;

class LeadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function newLeads(Request $request){
        $viewData['total_leads'] = Leads::count();
        $viewData['new_leads'] =  Leads::where('mark_as_client','0')->count();
        $viewData['lead_as_client'] =  Leads::where('mark_as_client','1')->count();
        $viewData['recommend_as_client'] =  Leads::where('mark_as_client','2')->count();
       	$viewData['pageTitle'] = "New Leads";
        $viewData['lead_type'] = 0;
        return view(roleFolder().'.leads.lists',$viewData);
    }

    public function leadsAsClient(Request $request){
        $viewData['total_leads'] = Leads::count();
        $viewData['new_leads'] =  Leads::where('mark_as_client','0')->count();
        $viewData['lead_as_client'] =  Leads::where('mark_as_client','1')->count();
        $viewData['recommend_as_client'] =  Leads::where('mark_as_client','2')->count();
        $viewData['pageTitle'] = "Leads as Client";
        $viewData['lead_type'] = 1;
        return view(roleFolder().'.leads.lists',$viewData);
    }
    public function recommendLeads(Request $request){
        
        $viewData['total_leads'] = Leads::count();
        $viewData['new_leads'] =  Leads::where('mark_as_client','0')->count();
        $viewData['lead_as_client'] =  Leads::where('mark_as_client','1')->count();
        $viewData['recommend_as_client'] =  Leads::where('mark_as_client','2')->count();
        $viewData['pageTitle'] = "Leads recommended as client";
        $viewData['lead_type'] = 2;
        return view(roleFolder().'.leads.lists',$viewData);
    }
    public function getNewList(Request $request)
    {
        $search = $request->input("search");
        $lead_type = $request->input("lead_type");
        $records = Leads::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("first_name","LIKE","%$search%");
                                $query->orWhere("last_name","LIKE","%$search%");
                                $query->orWhere("email","LIKE","%$search%");
                                $query->orWhere(DB::raw('concat(country_code,"",phone_no)') , 'LIKE' , "%$search%");
                            }
                        })
                        ->where("mark_as_client",$lead_type)
                        ->paginate();
        $viewData['records'] = $records;
        $viewData['lead_type'] = $lead_type;
        $view = View::make(roleFolder().'.leads.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function quickLead(){
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
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:leads',
            'country_code' => 'required',
            'phone_no' => 'required|numeric|unique:leads',
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

    public function deleteSingle($id){
        $id = base64_decode($id);
        Leads::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Leads::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function edit($id){
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
        $id = base64_decode($id);
        $object = Leads::find($id);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:leads,email,'.$object->id,
            'country_code' => 'required',
            'phone_no' => 'required|numeric|unique:leads,phone_no,'.$object->id,
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
        $object->gender = $request->input("gender");
        $object->country_id = $request->input("country_id");
        $object->state_id = $request->input("state_id");
        $object->city_id = $request->input("city_id");
        $object->address = $request->input("address");
        $object->zip_code = $request->input("zip_code");
        
        
        $object->visa_service_id = $request->input("visa_service_id");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Lead edited successfully";
        $response['redirect_back'] = baseUrl('leads');
        return response()->json($response);
    }

    public function markAsClient($id){
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
        $postData['professional'] = professionalDetail();
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

    public function assignLeads($id){

        $viewData['lead_id'] = base64_decode($id);
        $viewData['staff'] = User::where('role','!=','admin')->get();
        $viewData['pageTitle'] = "Assign Leads";

        //check for lead already added or not
        $assignedLead = AssignLeads::where('leads_id',base64_decode($id))->get();


        if(!empty($assignedLead))
        {
            $viewData['leadAssigned'] = $assignedLead;
        }

        $view = View::make(roleFolder().'.leads.modal.assign-lead',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 

    }

    public function saveAssignLeads(Request $request){

        $validator = Validator::make($request->all(), [
            'leads_id' => 'required',
            'user_id' => 'required',    
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

        $object1 = AssignLeads::where('leads_id',$request->input("leads_id"))->get();

        $user_id = $request->input("user_id");

        if(!empty($object1))
        {
            $counter = count($object1);
            for($i=0;$i < $counter;$i++){
                 //$id = base64_decode($object1[$i]->id);
                //print_r($object1[$i]->id);
                 AssignLeads::deleteRecord($object1[$i]->id);
            }
        }

        if(!empty($user_id)){
            $leads_id = $request->input("leads_id");
            for($i=0;$i < count($user_id);$i++){
                $object = new AssignLeads();
                //$object2->unique_id = randomNumber();
                $object->user_id = $user_id[$i];
                $object->leads_id = $leads_id;
                $object->save();
            }
        }
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('leads');
        $response['message'] = "Staff assigned successfully";
        
        return response()->json($response);
    }

    public function externalAssessments($lead_id,Request $request){
        $viewData['pageTitle'] = "Assessments";
        $lead_id = base64_decode($lead_id);
        $viewData['lead_id'] = $lead_id;
        return view(roleFolder().'.leads.assessments.lists',$viewData);
    }

    public function externalAssessmentsList(Request $request)
    {
        $search = $request->input("search");
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['search'] = $search;
        $apiData['lead_id'] = $request->input("lead_id");
        
        if($request->get("page")){
            $page = $request->get("page");
        }else{
            $page = 1;
        }
        $result = curlRequest("assessments/external-assessments?page=".$page,$apiData);
       
        $viewData = array();
        if($result['status'] == 'success'){
            $viewData['records'] = $result['data'];
            
            $response['last_page'] = $result['last_page'];
            $response['current_page'] = $result['current_page'];
            $response['total_records'] = $result['total_records'];
        }else{
            $viewData['records'] = array();
        }
        $view = View::make(roleFolder().'.leads.assessments.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function viewExternalAssessment($form_id,Request $request){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['form_id'] = $form_id;
        $result = curlRequest("assessments/view-external-assessment",$apiData);
        $viewData = array();
        $form_json = array();
        
        if($result['status'] == 'success'){
            $record = $result['data'];
           
            $viewData['record'] = $record;
            $form_json = json_decode($record['assessment_form']['form_json'],true);
            if($record['form_reply'] != ''){
                $postData = json_decode($record['form_reply'],true);
                $form_reply = array();
                foreach($form_json as $form){
                    $temp = array();
                   
                    if(isset($form['name']) && isset($postData[$form['name']])){
                        if(isset($form['values'])){
                            $values = $form['values'];
                            $final_values = array();
                            foreach($values as $value){
                                $tempVal = $value;
                                if(is_array($postData[$form['name']])){
                                    if(in_array($value['value'],$postData[$form['name']])){
                                        $tempVal['selected'] = true;
                                        
                                    }else{
                                        $tempVal['selected'] = false;
                                    }
                                }else{
                                    if($value['value'] == $postData[$form['name']]){
                                        $tempVal['selected'] = true;
                                        if($form['type'] == 'autocomplete'){
                                            $temp['value'] = $value['label'];
                                        }
                                    }else{
                                        $tempVal['selected'] = false;
                                    }
                                }
                                $final_values[] = $tempVal;
                            }
                        }else{
                            $temp['value'] = $postData[$form['name']];
                        }
                    }
                    if(isset($temp['value'])){
                        $temp['label'] = $form['label'];
                        $form_reply[] = $temp;
                    }
                }
                $form_json = $form_reply;
            }
            $viewData['assessment_id'] = $record['assessment']['unique_id'];
            $viewData['form_json'] = $form_json;
            
        }else{
            return redirect()->back()->with("error","Invalid assessment");
        }
        
        $viewData['pageTitle'] = "Assessment Reply";

        return view(roleFolder().'.leads.assessments.view',$viewData);
        
    }
}
