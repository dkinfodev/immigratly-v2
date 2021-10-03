<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;


class CronUrlsController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Cron Urls";
        return view(roleFolder().'.cron-urls.lists',$viewData);
    } 

    public function getAjaxList(Request $request){
        
        $search = $request->input("search");
        if($request->get("page")){
            $page = $request->get("page");
        }else{
            $page = 1;
        }
        $param['search'] = $search;
        $apiResponse = cronCurl("cron/fetch-crons?page=".$page,$param);
        
        $records = array();
        if($apiResponse['status'] == 'success'){
            $data = $apiResponse['data'];
            $records = $data['records'];
            $response['last_page'] = $data['last_page'];
            $response['current_page'] = $data['current_page'];
            $response['total_records'] = $data['total_records'];
        }
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.cron-urls.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);
    }
    public function add(){
        $viewData['pageTitle'] = "Add Category";
        $view = View::make(roleFolder().'.cron-urls.modal.add',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'url' => 'required',    
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

        $param = $request->input();
        $apiResponse = cronCurl("cron/add-cron",$param);
        // pre($apiResponse);
        if($apiResponse['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "Cron url added to queue";
            $response['redirect_back'] = baseUrl('cron-urls');
        }else{
            $response['status'] = false;
            $response['message'] = $apiResponse['message'];
        }
        return response()->json($response);
    }

    public function history($id)
    {
        $id = base64_decode($id);
        $apiResponse = cronCurl("cron/fetch-cron/".$id,array());
       
        if(isset($apiResponse['status']) && $apiResponse['status'] == 'success'){
            $record = $apiResponse['data'];
            $image_url = $apiResponse['image_url'];
        }else{
            return  redirect()->back()->with("error","No valid data found");
        }
        $viewData['record'] = $record;
        $viewData['image_url'] = $image_url;
        $viewData['pageTitle'] = "Screenshot History";
        return view(roleFolder().'.cron-urls.history',$viewData);
    } 
    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = Category::where('id',$id)->first();
        $viewData['pageTitle'] = "Edit Category";
        $view = View::make(roleFolder().'.cron-urls.modal.edit',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function update(Request $request){
        $id = $request->input('id');
        $id = base64_decode($id);

        $object = Category::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$object->id,   
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
        $response['redirect_back'] = baseUrl('category');
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        $param['id'] = $id;
        $param['action'] = 'single';
        $apiResponse = cronCurl("cron/delete-cron",$param);
        // pre($apiResponse);
        if($apiResponse['status'] == 'success'){
            return redirect()->back()->with("success",$apiResponse['message']);
        }else{
            return redirect()->back()->with("error",$apiResponse['message']);
        }
        
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $ids[$i] = base64_decode($ids[$i]);
        }
        $param['ids'] = $ids;
        $param['action'] = 'multiple';
        $apiResponse = cronCurl("cron/delete-cron",$param);
        // pre($apiResponse);
        if($apiResponse['status'] == 'success'){
            $response['status'] = true;
            \Session::flash('success', $apiResponse['message']); 
        }else{
            \Session::flash('error', 'Something wents wrong'); 
        }
        
        return response()->json($response);
    }
    
    public function showImgDiff(Request $request){
        $id = $request->input("id");
        $image1 = $request->input("image1");
        $image2 = $request->input("image2");
        
        $param['id'] = $id;
        $param['image1'] = $image1;
        $param['image2'] = $image2;
        $apiResponse = cronCurl("cron/show-image-diff",$param);
        // pre($apiResponse);
        if($apiResponse['status'] == 'success'){
            $response['status'] = true;
            $response['image_url'] = $apiResponse['image_url'];
        }else{
            $response['status'] = false;
            $response['message'] = 'Something wents wrong';
        }
        return response()->json($response);
        
    }
}
