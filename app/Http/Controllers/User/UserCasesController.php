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

}
