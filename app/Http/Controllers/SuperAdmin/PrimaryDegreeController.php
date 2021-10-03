<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\PrimaryDegree;


class PrimaryDegreeController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    
    public function list()
    {
        $viewData['pageTitle'] = "Primary Degree";
        return view(roleFolder().'.primary-degree.lists',$viewData);
    } 


    

    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = PrimaryDegree::where('id',$id)->first();
        $viewData['pageTitle'] = "Edit Primary Degree";
        $view = View::make(roleFolder().'.primary-degree.modal.edit',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function add(){
        $viewData['pageTitle'] = "Add Primary Degree";
        $view = View::make(roleFolder().'.primary-degree.modal.add',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function getAjaxList(Request $request){
        
        $search = $request->input("search");
        $records = PrimaryDegree::
                        where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%".$search."%");
                            }
                        })
                        ->orderBy('id',"desc")
                        ->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.primary-degree.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',    
            'level' => 'required',
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

        $object =  new PrimaryDegree;
        $object->name = $request->input("name");
        $object->level = $request->input("level");

        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('primary-degree');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }
    public function update(Request $request){
        $id = $request->input('id');
        $id = base64_decode($id);

        $object = PrimaryDegree::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'level' => 'required',
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
        $object->level = $request->input("level");
        $object->added_by = \Auth::user()->id;
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('primary-degree');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }
    public function deleteSingle($id){
        $id = base64_decode($id);
        PrimaryDegree::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            PrimaryDegree::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
}
