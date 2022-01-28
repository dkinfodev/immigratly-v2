<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\Tags;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function tags()
    {
        $viewData['pageTitle'] = "Tags";
        $viewData['activeTab'] = "tags";
        return view(roleFolder().'.tags.lists',$viewData);
    } 

    public function getAjaxList(Request $request){
        
        $search = $request->input("search");
        $records = Tags::where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%".$search."%");
                            }
                        })
                        ->orderBy('id',"desc")
                        ->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.tags.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
    public function add(){
        $viewData['pageTitle'] = "Add Tag";
        $view = View::make(roleFolder().'.tags.modal.add',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags,name',    
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

        $object =  new Tags();
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('Tags');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = Tags::where('id',$id)->first();
        $viewData['pageTitle'] = "Edit Tag";
        $view = View::make(roleFolder().'.tags.modal.edit',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function update(Request $request){
        $id = $request->input('id');
        $id = base64_decode($id);

        $object = Tags::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags,name,'.$object->id,   
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
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('Tags');
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        Tags::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Tags::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
}
