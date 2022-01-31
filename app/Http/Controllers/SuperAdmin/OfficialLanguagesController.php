<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use View;

use App\Models\OfficialLanguages;

class OfficialLanguagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function languages()
    {
        $viewData['activeTab'] = "official-languages";
        $viewData['total_bodies'] = OfficialLanguages::count();
        $viewData['pageTitle'] = "Official Languages";
        return view(roleFolder().'.official-languages.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $keyword = $request->input("search");
        $records = OfficialLanguages::where(function($query) use($keyword){
                                    if($keyword != ''){
                                        $query->where("name","LIKE",$keyword."%");
                                    }
                                })
                                ->orderBy('id',"desc")
                                ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.official-languages.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['activeTab'] = "official-languages";
        $viewData['pageTitle'] = "Add Official Language";
        return view(roleFolder().'.official-languages.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:official_languages',
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
        $object =  new OfficialLanguages();
        $object->name = $request->input("name");
        $object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('official-languages');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['activeTab'] = "official-languages";
        $viewData['record'] = OfficialLanguages::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Official Language";
        return view(roleFolder().'.official-languages.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  OfficialLanguages::find($id);
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
        $response['redirect_back'] = baseUrl('official-languages');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        OfficialLanguages::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            OfficialLanguages::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    public function search($keyword){
        $keyword = $keyword;
        
        $records = OfficialLanguages::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.official-languages.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
}
