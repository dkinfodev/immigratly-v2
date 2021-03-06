<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\User;
use App\Models\UserCases;
use App\Models\VisaServices;
use App\Models\UserDetails;
use App\Models\UserCaseComments;
use App\Models\UserWithProfessional;

class UserCasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function index()
    {
        $viewData['pageTitle'] = "My Cases";
        $viewData['activeTab'] = "my-cases";
        return view(roleFolder().'.cases.my-cases.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = UserCases::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("case_title","LIKE","%$search%");
                            }
                        })
                        ->where("user_id",\Auth::user()->unique_id)
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.cases.my-cases.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function saveCase(Request $request){
     
        $validator = Validator::make($request->all(), [
            'case_title' => 'required',
            'visa_service_id' => 'required',
            'description' => 'required', 
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
 

        $object = new UserCases;
        $object->user_id = \Auth::user()->unique_id;
        $object->case_title = $request->input("case_title");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->description = $request->input("description");
        $object->unique_id = randomNumber();
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('my-cases');
        $response['message'] = "Case added sucessfully";
        
        return response()->json($response);
    }
    
    public function addcase()
    {
        $viewData['pageTitle'] = "Add Case";
        $viewData['activeTab'] = "my-cases";

        $visa_services = VisaServices::get();
        
        $viewData['visa_services'] = $visa_services;
        
        return view(roleFolder().'.cases.my-cases.add',$viewData);
    }

    public function editcase($id)
    {
        $object = UserCases::where('unique_id',$id)->first();
        $viewData['record'] = $object;
        $viewData['pageTitle'] = "Edit Cases";
        $viewData['activeTab'] = "my-cases";
        $visa_services = VisaServices::get();
        $viewData['visa_services'] = $visa_services;
        return view(roleFolder().'.cases.my-cases.edit',$viewData);
    }

    public function viewCase($id)
    {
        $object = UserCases::where('unique_id',$id)->where("user_id",\Auth::user()->unique_id)->first();
        if(empty($object)){
            return redirect()->back()->with("error","Invalid case.");
        }
        $viewData['record'] = $object;
        $viewData['pageTitle'] = "Edit Cases";
        $viewData['activeTab'] = "my-cases";
        $visa_services = VisaServices::get();
        $viewData['visa_services'] = $visa_services;
        $comments = UserCaseComments::where("user_id",\Auth::user()->unique_id)
                                ->where('case_id',$id)
                                ->groupBy("professional")
                                ->orderBy("id","desc")
                                ->with("caseComments")
                                ->get();
        $viewData['comments'] = $comments;
        return view(roleFolder().'.cases.my-cases.view',$viewData);
    }


    public function updateCase(Request $request){
        $id = $request->input("id");
        $object = UserCases::where('unique_id',$id)->first();

        $validator = Validator::make($request->all(), [
            'case_title' => 'required',
            'visa_service_id' => 'required',
            'description' => 'required', 
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
        
        $object->user_id = \Auth::user()->unique_id;
        $object->case_title = $request->input("case_title");
        $object->visa_service_id = $request->input("visa_service_id");
        $object->description = $request->input("description");
        $object->unique_id = randomNumber();
        $object->save();
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('my-cases');
        $response['message'] = "Case added sucessfully";
        return response()->json($response);
    }
   
    public function deleteSingle($id){
        $id = base64_decode($id);
        UserCases::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            UserCases::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function startCaseWithProfessional($case_id,$subdomain,Request $request){

        $record = UserCases::where("unique_id",$case_id)->first();
        $apiData['case_title'] = $record->case_title;
        $apiData['description'] = $record->description;
        $apiData['visa_service_id'] = $record->visa_service_id;
        
        unset($apiData['_token']);
        $apiData['subdomain'] = $subdomain;
        $apiData['client_id'] = \Auth::user()->unique_id;
        $api_response = professionalCurl('cases/create-case',$subdomain,$apiData);
       
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $record->assign_case = 1;
            $record->assign_to = $subdomain;
            $record->save();

            $check = UserWithProfessional::where("professional",$subdomain)->where("user_id",\Auth::user()->unique_id)->count();
            // $user = UserWithProfessional::firstOrNew(array('professional' => $subdomain,"user_id"=>\Auth::user()->unique_id));
            if($check == 0){
                $object = new UserWithProfessional();
                $object->professional = $subdomain;
                $object->user_id = \Auth::user()->unique_id;
                $object->save();
            }
            return redirect(baseUrl('cases/pending'))->with("success","Case posted with professional successfully");
        }else{
            return redirect()->back()->with("error","Something went wrong while posting case. Try again");
        }
        // return response()->json($response);
    }

    public function postComments($case_id,Request $request){
        $validator = Validator::make($request->all(), [
            'comments' => 'required'
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
        $record = \DB::table(MAIN_DATABASE.".user_cases")->where('unique_id',$case_id)->first();

        
        $insData['comments'] = $request->input("comments");
        $insData['professional'] = $request->input("professional");
        $insData['unique_id'] = randomNumber();
        $insData['case_id'] = $case_id;
        $insData['user_id'] = $record->user_id;
        $insData['status'] = 0;
        $insData['send_by'] = 'client';
        $insData['added_by'] = \Auth::user()->unique_id;
        $insData['created_at'] = date("Y-m-d H:i:s");
        $insData['updated_at'] = date("Y-m-d H:i:s");
        \DB::table(MAIN_DATABASE.".user_case_comments")->insert($insData);
        $user = DB::table(MAIN_DATABASE.".users")->where("unique_id",$record->user_id)->first();
        $professional = professionalDetail($request->input("professional"));
        $mail_message = "<p>Hello ".$professional->company_name."<br>Client has send his comment for case $record->case_title. Please have a look.</p>";
        $mail_message .= "<p><a href='".url('admin/users-cases/view/'.$case_id)."' style='display:inline-block;text-decoration:none;margin-top:10px;padding:10px 20px;background-color:#377dff;color:#FFF'>Click to view case</a></p>";
        $parameter['subject'] = "Comment added to your user case. ";
        $mailData['mail_message'] = $mail_message;
        $view = View::make('emails.notification',$mailData);
  
        $message = $view->render();
        $parameter['to'] = $user->email;
        $parameter['to_name'] = $user->first_name." ".$user->last_name;
        $parameter['message'] = $message;
        $parameter['view'] = "emails.notification";
        $parameter['data'] = $mailData;
        $mailRes = sendMail($parameter);
        
        $response['status'] = true;
        $response['message'] = "Your comment posted successfully";
        return response()->json($response);

    }

    public function editComment($id,Request $request){
        $record = \DB::table(MAIN_DATABASE.".user_case_comments")->where("unique_id",$id)->first();
        $viewData['pageTitle'] = "Edit Comment";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.users-cases.modal.edit-comment',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function updateComment($id,Request $request){
        $validator = Validator::make($request->all(), [
            'comments' => 'required'
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
        $insData['comments'] = $request->input("comments");
        $insData['updated_at'] = date("Y-m-d H:i:s");
        \DB::table(MAIN_DATABASE.".user_case_comments")->where('unique_id',$id)->update($insData);
       
        
        $response['status'] = true;
        $response['message'] = "Your comment edited successfully";
        return response()->json($response);
    }

    public function deleteComment($id){
        \DB::table(MAIN_DATABASE.".user_case_comments")->where("unique_id",$id)->delete();
        return redirect()->back()->with("success","Comment deleted successfully");
    }
}
