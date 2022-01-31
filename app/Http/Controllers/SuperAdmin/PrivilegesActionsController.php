<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use App\Models\ProfessionalPrivileges;
use App\Models\PrivilegesActions;

class PrivilegesActionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index($id)
    {
        $id = base64_decode($id);    
        $viewData['total_bodies'] = PrivilegesActions::where('id',$id)->count();
        $viewData['moduleId'] = $id;

        $moduleName = ProfessionalPrivileges::where('id',$id)->first();
        $viewData['moduleName'] = $moduleName->name;

        $viewData['pageTitle'] = "Privilege Actions";
        $viewData['activeTab'] = "privileges";
        return view(roleFolder().'.privileges-actions.lists',$viewData);
    } 


    public function getAjaxList(Request $request)
    {

        $id = $request->input('id');
        $id = base64_decode($id);
        $viewData['moduleId'] = $id;

        $search = $request->input("search");
        $records = PrivilegesActions::where('module_id',$id)->orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.privileges-actions.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }


    public function add($id){

        $id = base64_decode($id);

        $viewData['pageTitle'] = "Add Professional Modules";
        $moduleName = ProfessionalPrivileges::where('id',$id)->first();
        $viewData['moduleName'] = $moduleName->name;
        $viewData['moduleId'] = $id;
        $viewData['activeTab'] = "privileges";
        return view(roleFolder().'.privileges-actions.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:privileges_actions,name',
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
        $object =  new PrivilegesActions;
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $module_id = $request->input("module_id");
        
        $object->module_id = base64_decode($module_id);
        //$object->unique_id = randomNumber();
        $module_id = $request->input("module_id");
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('privileges/action/'.$module_id);
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($mid,$id){

        $mid = base64_decode($mid);
        
        $moduleName = ProfessionalPrivileges::where('id',$mid)->first();
        $viewData['moduleName'] = $moduleName->name;
        $viewData['moduleId'] = $mid;
        $id = base64_decode($id);
        $viewData['record'] = PrivilegesActions::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Professional Modules";
        $viewData['activeTab'] = "privileges";
        return view(roleFolder().'.privileges-actions.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  PrivilegesActions::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:privileges_actions,name,'.$object->id,            
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
        $module_id = $request->input("module_id");
        $object->save();

        $response['status'] = true;
        $response['message'] = "Record updated successfully";
        $response['redirect_back'] = baseUrl('privileges/action/'.$module_id);
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        PrivilegesActions::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            PrivilegesActions::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
    public function search($keyword){
        $keyword = $keyword;
        
        $records = PrivilegesActions::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.privileges-actions.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
