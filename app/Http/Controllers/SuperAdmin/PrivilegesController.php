<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use App\Models\ProfessionalPrivileges;

class PrivilegesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['total_bodies'] = ProfessionalPrivileges::count();
        $viewData['pageTitle'] = "Professional Privileges";
        $viewData['activeTab'] = "privileges";
        return view(roleFolder().'.privileges.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $records = ProfessionalPrivileges::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.privileges.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Modules";
        $viewData['activeTab'] = "privileges";
        return view(roleFolder().'.privileges.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:professional_privileges,name',
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
        $object =  new ProfessionalPrivileges;
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        //$object->module_action = $request->input("module_action");
        //$object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('privileges');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = ProfessionalPrivileges::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Modules";
        $viewData['activeTab'] = "privileges";
        return view(roleFolder().'.privileges.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  ProfessionalPrivileges::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:professional_privileges,name,'.$object->id,
            
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

        $object->name = $request->input("name");
        //$object->module_action = $request->input("module_action");
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/privileges');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        ProfessionalPrivileges::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            ProfessionalPrivileges::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
    public function search($keyword){
        $keyword = $keyword;
        
        $records = ProfessionalPrivileges::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.privileges.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
