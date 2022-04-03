<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;
use View;

use App\Models\GlobalForms;
use App\Models\Articles;

class GlobalFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function forms(){
        $viewData['pageTitle'] = "Global Forms";
        $viewData['activeTab'] = 'global-forms'; 
        return view(roleFolder().'.global-forms.lists',$viewData);
    }

    public function getFormList(Request $request)
    {
        $search = $request->input("search");
        $records = GlobalForms::
                        orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.global-forms.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addForm(Request $request){
    
        $viewData['pageTitle'] = "Add Form";
        $viewData['activeTab'] = 'global-forms';
        return view(roleFolder().'.global-forms.add',$viewData);
    }

    public function saveForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_title' => 'required',
            'form_json' => 'required'
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
        $form_json = $request->input("form_json");
        $json_data = array();
        foreach($form_json as $json){
            $temp = $json;
            foreach($json as $key => $value){
                if($value == "true"){
                    $temp[$key] = true;
                }
                if($value == "false"){
                    $temp[$key] = false;
                }
            }
            $json_data[] = $temp;
        }
        $object = new GlobalForms;
        $object->unique_id = randomNumber();
        $object->uuid = generateUUID();
        $object->form_title =  $request->input("form_title");
        $object->form_json = json_encode($json_data);
        $object->added_by = \Auth::user()->unique_id;
        $object->save();
        //$result = curlRequest("assessments/save-form",$apiData);
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('global-forms');
        $response['message'] = "Form added sucessfully";

        return response()->json($response);
    }

    public function editForm($id,Request $request){
        
        $viewData['pageTitle'] = "Edit Form";
        
        $viewData['activeTab'] = 'global-forms';
        $viewData['record'] = GlobalForms::where('unique_id',$id)->first();    
        return view(roleFolder().'.global-forms.edit',$viewData);
        
    }

    public function updateForm($id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_title' => 'required',
            'form_json' => 'required'
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
        $form_json = $request->input("form_json");
        $json_data = array();
        foreach($form_json as $json){
            $temp = $json;
            foreach($json as $key => $value){
                if($value == "true"){
                    $temp[$key] = true;
                }
                if($value == "false"){
                    $temp[$key] = false;
                }
            }
            $json_data[] = $temp;
        }
        
        $object = GlobalForms::where('unique_id',$id)->first();
       
        $object->form_title =  $request->input("form_title");
        $object->form_json = json_encode($json_data);
        //$object->added_by = \Auth::user()->unique_id;
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('global-forms');
        $response['message'] = "Form edited sucessfully";

        return response()->json($response);
    }

    public function deleteFormSingle($id){
       
        $id = base64_decode($id);
        GlobalForms::deleteRecord($id);
        return redirect()->back()->with("success","Form has been deleted!");
        
    }

    public function deleteFormMultiple(Request $request){
        
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            GlobalForms::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Forms deleted successfully'); 
        return response()->json($response);
    }

    public function viewForm($assessment_id,$id,Request $request){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['form_id'] = $id;
        $result = curlRequest("assessments/fetch-form",$apiData);
        $viewData = array();
        $form_json = array();
        if($result['status'] == 'success'){
            $record = $result['data'];
            $viewData['record'] = $record;
            $form_json = json_decode($record['form_json'],true);
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
            $viewData['assessment_id'] = $assessment_id;
            $viewData['form_json'] = $form_json;
            
        }else{
            return redirect()->back()->with("error","Invalid assessment");
        }
        
        $viewData['pageTitle'] = "Assessment Reply";
        $viewData['activeTab'] = 'assessments';
        return view(roleFolder().'.assessments.forms.view',$viewData);
    }
}
