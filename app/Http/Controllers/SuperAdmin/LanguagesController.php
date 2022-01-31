<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\Languages;

class LanguagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function languages()
    {
        $viewData['total_bodies'] = Languages::count();
        $viewData['pageTitle'] = "Languages";
        $viewData['activeTab'] = 'languages';
        return view(roleFolder().'.languages.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $keyword = $request->input("search");
        $records = Languages::where(function($query) use($keyword){
                                    if($keyword != ''){
                                        $query->where("name","LIKE",$keyword."%");
                                    }
                                })
                                ->orderBy('id',"desc")
                                ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.languages.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Language";
        $viewData['activeTab'] = 'languages';
        return view(roleFolder().'.languages.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:languages',
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
        $object =  new Languages;
        $object->name = $request->input("name");
        $object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('languages');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = Languages::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Language";
        $viewData['activeTab'] = 'languages';
        return view(roleFolder().'.languages.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  Languages::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:languages,name,'.$object->id,
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
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/languages');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        Languages::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Languages::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    public function search($keyword){
        $keyword = $keyword;
        
        $records = Languages::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.languages.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
