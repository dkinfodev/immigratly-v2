<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use App\Models\EmployeePrivileges;

class EmployeePrivilegesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['total_bodies'] = EmployeePrivileges::count();
        $viewData['pageTitle'] = "Employee Privileges";
        $viewData['activeTab'] = 'employee-privileges';
        return view(roleFolder().'.employee-privileges.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $records = EmployeePrivileges::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.employee-privileges.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Modules";
        $viewData['activeTab'] = 'employee-privileges';
        return view(roleFolder().'.employee-privileges.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:employee_privileges,name',
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
        $object =  new EmployeePrivileges;
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        //$object->module_action = $request->input("module_action");
        //$object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('employee-privileges');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = EmployeePrivileges::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Modules";
        $viewData['activeTab'] = 'employee-privileges';
        return view(roleFolder().'.employee-privileges.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  EmployeePrivileges::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:employee_privileges,name,'.$object->id,
            
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
        $object->slug = str_slug($request->input("name"));
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/employee-privileges');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        EmployeePrivileges::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            EmployeePrivileges::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
    public function search($keyword){
        $keyword = $keyword;
        
        $records = EmployeePrivileges::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.employee-privileges.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
