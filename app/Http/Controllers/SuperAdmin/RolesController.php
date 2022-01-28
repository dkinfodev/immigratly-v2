<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;
use App\Models\Roles;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index(Request $request){

        $viewData['pageTitle'] = "Roles";
        
        return view(roleFolder().'.roles.lists',$viewData);
    }

    public function getNewList(Request $request)
    {
        $search = $request->input("search");
        $records = Roles::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("first_name","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.roles.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function quickLead(){
        $viewData['pageTitle'] = "Quick Lead";
        $viewData['visa_services'] = Roles::orderBy('id',"asc")->get();
       
        $view = View::make(roleFolder().'.roles.modal.roles',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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

        $object = new Roles();
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->save();

        $response['status'] = true;
        $response['message'] = "Role added successfully";
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        Roles::deleteRecord($id);
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
        $record = Roles::find($id);
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Role";
        return view(roleFolder().'.roles.edit',$viewData);
    }
}
