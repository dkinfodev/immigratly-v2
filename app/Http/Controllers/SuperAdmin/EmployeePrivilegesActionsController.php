<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use App\Models\EmployeePrivileges;
use App\Models\EmployeePrivilegesActions;

class EmployeePrivilegesActionsController extends Controller
{
    public function __construct()
    { 
        $this->middleware('super_admin');
    }

    public function index($id)
    {
        $id = base64_decode($id);    
        $viewData['total_bodies'] = EmployeePrivileges::where('id',$id)->count();
        $viewData['moduleId'] = $id;

        $moduleName = EmployeePrivileges::where('id',$id)->first();
        $viewData['moduleName'] = $moduleName->name;

        $viewData['pageTitle'] = "Employee Privilege Actions";
        return view(roleFolder().'.employee-privileges-actions.lists',$viewData);
    } 


    public function getAjaxList(Request $request)
    {

        $id = $request->input('id');
        $id = base64_decode($id);
        $viewData['moduleId'] = $id;

        $search = $request->input("search");
        $records = EmployeePrivilegesActions::where('module_id',$id)->orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.employee-privileges-actions.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }


    public function add($id){

        $id = base64_decode($id);

        $viewData['pageTitle'] = "Add Action";
        $moduleName = EmployeePrivileges::where('id',$id)->first();
        $viewData['moduleName'] = $moduleName->name;
        $viewData['moduleId'] = $id;
        return view(roleFolder().'.employee-privileges-actions.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:employee_modules_action,name',
            'module_id' => 'required',
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
        $object =  new EmployeePrivilegesActions;
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $module_id = $request->input("module_id");
        
        $object->module_id = base64_decode($module_id);
        //$object->unique_id = randomNumber();
        $module_id = $request->input("module_id");
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('employee-privileges/action/'.$module_id);
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($mid,$id){

        $mid = base64_decode($mid);
        
        $moduleName = EmployeePrivileges::where('id',$mid)->first();
        $viewData['moduleName'] = $moduleName->name;
        $viewData['moduleId'] = $mid;
        $id = base64_decode($id);
        $viewData['record'] = EmployeePrivilegesActions::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Action";
        return view(roleFolder().'.employee-privileges-actions.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  EmployeePrivilegesActions::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:employee_modules_action,name,'.$object->id,            
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
        $object->slug = str_slug($request->input("name"));
        $module_id = $request->input("module_id");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Record updated successfully";
        $response['redirect_back'] = baseUrl('employee-privileges/action/'.$module_id);
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        EmployeePrivilegesActions::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            EmployeePrivilegesActions::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
    public function search($keyword){
        $keyword = $keyword;
        
        $records = EmployeePrivilegesActions::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.employee-privileges-actions.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
