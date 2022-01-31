<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use App\Models\DocumentFolder;

class DocumentFolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Document Folder";
        $viewData['activeTab'] = 'document-folder';
        return view(roleFolder().'.document-folder.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $keyword = $request->input("search");
        $records = DocumentFolder::where(function($query) use($keyword){
                                    if($keyword != ''){
                                        $query->where("name","LIKE",$keyword."%");
                                    }
                                })
                                ->orderBy('id',"desc")
                                ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.document-folder.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Document Folder";
        $viewData['activeTab'] = 'document-folder';
        return view(roleFolder().'.document-folder.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:documents_folder',
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
        $object =  new DocumentFolder();
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('document-folder');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = DocumentFolder::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Document Folder";
        $viewData['activeTab'] = 'document-folder';
        return view(roleFolder().'.document-folder.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $object =  DocumentFolder::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:documents_folder,name,'.$object->id,
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
        $response['redirect_back'] = baseUrl('document-folder');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        // DocumentFolder::where("id",$id)->delete();
        DocumentFolder::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            DocumentFolder::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function search($keyword){
        $keyword = $keyword;
        $records = DocumentFolder::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.document-folder.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
