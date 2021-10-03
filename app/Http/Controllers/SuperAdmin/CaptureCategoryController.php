<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\CaptureCategory;

class CaptureCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function category()
    {
        $viewData['pageTitle'] = "Categories";
        return view(roleFolder().'.capture-category.lists',$viewData);
    } 

    public function getAjaxList(Request $request){
        
        $search = $request->input("search");
        $records = CaptureCategory::where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%".$search."%");
                            }
                        })
                        ->orderBy('id',"desc")
                        ->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.capture-category.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
    public function add(){
        $viewData['pageTitle'] = "Add Category";
        $view = View::make(roleFolder().'.capture-category.modal.add',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:capture_category,name',    
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

        $object =  new CaptureCategory();
        $object->name = $request->input("name");
        $object->short_name = $request->input("short_name");
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('capture-category');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = CaptureCategory::where('id',$id)->first();
        $viewData['pageTitle'] = "Edit Category";
        $view = View::make(roleFolder().'.capture-category.modal.edit',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function update(Request $request){
        $id = $request->input('id');
        $id = base64_decode($id);

        $object = CaptureCategory::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:capture_category,name,'.$object->id,   
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
        $object->short_name = $request->input("short_name");
        $object->save();
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('capture-category');
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        CaptureCategory::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            CaptureCategory::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
    
}
