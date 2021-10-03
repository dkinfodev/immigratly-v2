<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;
use View;

use App\Models\Articles;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function publishArticles()
    {
       	$viewData['pageTitle'] = "Articles";
        $result = curlRequest("articles/count");
        $publish = 0;
        $draft = 0;
        if($result['status'] == 'success'){
            $data = $result['data'];
            $publish = $data['publish'];
            $draft = $data['draft'];
        }
        $total_articles = $publish+$draft;
        $viewData['total_articles'] = $total_articles;
        $viewData['publish'] = $publish;
        $viewData['draft'] = $draft;
        $viewData['status'] = 'publish';
        return view(roleFolder().'.articles.lists',$viewData);
    }

    public function draftArticles()
    {
        $viewData['pageTitle'] = "Articles";
        $result = curlRequest("articles/count");
        $publish = 0;
        $draft = 0;
        if($result['status'] == 'success'){
            $data = $result['data'];
            $publish = $data['publish'];
            $draft = $data['draft'];
        }
        $total_articles = $publish+$draft;
        $viewData['total_articles'] = $total_articles;
        $viewData['publish'] = $publish;
        $viewData['draft'] = $draft;
        $viewData['status'] = 'draft';
        return view(roleFolder().'.articles.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $subdomain = \Session::get("subdomain");
        $search = $request->input("search");
        $status = $request->input("status");
        $apiData['search'] = $search;
        $apiData['status'] = $status;
        if($request->get("page")){
            $page = $request->get("page");
        }else{
            $page = 1;
        }
        $result = curlRequest("articles?page=".$page,$apiData);
        
        $records = array();
        if($result['status'] == 'success'){
            $data = $result['data'];
            $records = $data['data'];
            $response['last_page'] = $data['last_page'];
            $response['current_page'] = $data['current_page'];
            $response['total_records'] = $data['total'];
        }
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.articles.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        
        return response()->json($response);
    }

    public function add(){

        $viewData['pageTitle'] = "Add Article";
        $services = DB::table(MAIN_DATABASE.".visa_services")->get();
        $viewData['services'] = $services;

        $tags = DB::table(MAIN_DATABASE.".tags")->get();
        $viewData['tags'] = $tags;
        $timestamp = time();
        $viewData['timestamp'] = $timestamp;
        return view(roleFolder().'.articles.add',$viewData);
    }


    public function save(Request $request){
        // pre($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            // 'tags'=>'required|array',
            'share_with'=>'required',
            // 'images'=>'required',
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

        $apiData = $request->input();
        $apiData['added_by'] = \Auth::user()->unique_id;
        
        $result = curlRequest("articles/save",$apiData);
        // pre($result);
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['redirect_back'] = baseUrl('articles');
            $response['message'] = $result['message'];
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Some issue while saving article";

        }
        return response()->json($response);
    }
 
    public function edit($unique_id,Request $request){
        $viewData['pageTitle'] = "Edit Article";
        $services = DB::table(MAIN_DATABASE.".visa_services")->get();
        $viewData['services'] = $services;

        $tags = DB::table(MAIN_DATABASE.".tags")->get();
        $viewData['tags'] = $tags;
        $timestamp = time();
        $viewData['timestamp'] = $timestamp;
        $apiData['article_id'] = $unique_id;
        $result = curlRequest("articles/fetch-article",$apiData);

        if($result['status'] == 'success'){
            $viewData['record'] = $result['data'];
        }else{
            return redirect()->back()->with("error","Article not found");
        }
        return view(roleFolder().'.articles.edit',$viewData);
    }


    public function update($unique_id,Request $request){
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'share_with'=>'required',
            // 'images'=>'required',
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

        $apiData = $request->input();
        $apiData['article_id'] = $unique_id;
        $apiData['added_by'] = \Auth::user()->unique_id;
        
        $result = curlRequest("articles/update",$apiData);
        // pre($result);
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['redirect_back'] = baseUrl('articles');
            $response['message'] = $result['message'];
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Some issue while saving article";

        }
        return response()->json($response);
    }
    public function deleteImage($id,Request $request){
       
        $apiData['article_id'] = $id;
        $apiData['image'] = $request->get("image");
        $result = curlRequest("articles/delete-image",$apiData);
        // pre($result);
        if($result['status'] == 'success'){
            return redirect()->back()->with("success","Image has been deleted!");
        }else{
            return redirect()->back()->with("error","Image not deleted. Try again!");

        }
        
    }
    public function deleteSingle($id){
       
        $apiData['article_id'] = $id;
        $result = curlRequest("articles/delete",$apiData);
        // pre($result);
        if($result['status'] == 'success'){
            $response['status'] = true;
            $response['redirect_back'] = baseUrl('articles');
            $response['message'] = $result['message'];
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Some issue while saving article";

        }
        return redirect()->back()->with("success","Article has been deleted!");
    }
}
