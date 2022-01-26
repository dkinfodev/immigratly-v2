<?php

namespace App\Http\Controllers\Telecaller;

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
        $this->middleware('telecaller');
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
        $viewData['recommend_as_client'] =  Leads::where('mark_as_client','2')->count();
       	$viewData['pageTitle'] = "New Leads";
        $viewData['lead_type'] = 0;
        return view(roleFolder().'.leads.lists',$viewData);
    }
    public function assignedLeads(Request $request){
        $viewData['total_leads'] = Leads::count();
        $viewData['new_leads'] =  Leads::where('mark_as_client','0')->count();
        $viewData['lead_as_client'] =  Leads::where('mark_as_client','1')->count();
        $viewData['recommend_as_client'] =  Leads::where('mark_as_client','2')->count();
        $viewData['pageTitle'] = "Assigned Leads";
        $viewData['lead_type'] = 1;
        $viewData['activeTab'] = "leads";
        return view(roleFolder().'.leads.lists',$viewData);
    }
    public function recommendLeads(Request $request){
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
        $viewData['recommend_as_client'] =  Leads::where('mark_as_client','2')->count();
        $viewData['pageTitle'] = "Leads recommended as client";
        $viewData['lead_type'] = 2;
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
        $viewData['activeTab'] = "leads";
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
    
    public function recommendAsClient($id,Request $request){
        if(!role_permission('leads','recommend-as-client')){
            if($request->ajax()){
                $response['status'] = "error";
                $response['message'] = ACCESS_DENIED_MSG;
                return response()->json($response);
            }else{
                return redirect(baseUrl('/'))->with("error",ACCESS_DENIED_MSG);
            }
        }
        
        $object = Leads::where('unique_id',$id)->first();
        $object->mark_as_client = 2;
        $object->save();
        return redirect()->back()->with("success","Lead recommended as client");
    }

}
