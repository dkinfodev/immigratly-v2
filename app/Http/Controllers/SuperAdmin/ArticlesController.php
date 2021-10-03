<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DB;
use View;

use App\Models\Articles;
use App\Models\ArticleTags;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }
    public function publishArticles()
    {
        $viewData['pageTitle'] = "Articles";
        
        $publish = 0;
        $draft = 0;
        
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
       
        $search = $request->input("search");
        $status = $request->input("status");
        $apiData['search'] = $search;
        $apiData['status'] = $status;
        if($request->get("page")){
            $page = $request->get("page");
        }else{
            $page = 1;
        }
        $search = $request->input("search");
        $records = Articles::with(['Category'])
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("title","LIKE","%$search%");
                            }
                        })
                        ->whereHas("Category")
                        ->where("status",$request->input("status"))
                        ->orderBy("id","desc")
                        ->paginate();
        
        
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.articles.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        
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
        
        $unique_id = randomNumber();
        $check_name_count = Articles::where("title",$request->input('title'))->count();
        $slug = str_slug($request->input("title"));
        if($check_name_count > 0){
            $slug = $slug."-".($check_name_count+1);
        }
        $object = new Articles();
        $object->unique_id = $unique_id;
        $object->title = $request->input("title");
        $object->slug = $slug;
        $object->description = $request->input("description");
        $object->short_description = $request->input("short_description");
        $object->category_id = $request->input("category_id");
        $object->share_with = $request->input("share_with");
        $object->status = "publish";
        // if($request->input("content_block")){
        //     $object->content_block = $request->input("content_block");
        // }

        $object->added_by = \Auth::user()->unique_id;
        if($request->input("timestamp")){
            $timestamp = $request->input("timestamp");
            $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
            $filename = array();
            for($f = 0; $f < count($files);$f++){
                $file_arr = explode("/",$files[$f]);
                $filename[] = end($file_arr);
                $file_name =  end($file_arr);
                $destinationPath = public_path("/uploads/articles/".$file_name);
                copy($files[$f], $destinationPath);
                unlink($files[$f]);
            }
            if(file_exists(public_path()."/uploads/temp/". $timestamp)){
                rmdir(public_path()."/uploads/temp/". $timestamp);
            }
            if(!empty($filename)){
                $object->images = implode(",",$filename);
            }
        }
        $object->save();
        $id  = $object->id;
        if($request->input("tags")){
            $tags = $request->input("tags");
            for($i=0;$i < count($tags);$i++){
                $object2 = new ArticleTags();
                $object2->article_id = $id;
                $object2->tag_id = $tags[$i];
                $object2->save();
            }
        }

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('articles');
        $response['message'] = "Record added successfully";
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
        $record = Articles::with(['Category','ArticleTags'])
                            ->where("unique_id",$unique_id)
                            ->first();
        $viewData['record'] = $record;
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

        $object = Articles::where('unique_id',$unique_id)->first();
        $images = $object->images;
        $check_name_count = Articles::where("title",$request->input('title'))
                                    ->where("unique_id","!=",$unique_id)
                                    ->count();
        $slug = str_slug($request->input("title"));
        if($check_name_count > 0){
            $slug = $slug."-".($check_name_count+1);
        }
        $object->title = $request->input("title");
        $object->slug = $slug;
        $object->description = $request->input("description");
        $object->short_description = $request->input("short_description");
        $object->category_id = $request->input("category_id");
        $object->share_with = $request->input("share_with");
        // if($request->input("content_block")){
        //     $object->content_block = $request->input("content_block");
        // }
        if($request->input("timestamp")){
            $timestamp = $request->input("timestamp");
            $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
            $filename = array();
            for($f = 0; $f < count($files);$f++){
                $file_arr = explode("/",$files[$f]);
                $filename[] = end($file_arr);
                $file_name =  end($file_arr);
                $destinationPath = public_path("/uploads/articles/".$file_name);
                copy($files[$f], $destinationPath);
                unlink($files[$f]);
            }
            if(file_exists(public_path()."/uploads/temp/". $timestamp)){
                rmdir(public_path()."/uploads/temp/". $timestamp);
            }
            if(!empty($filename)){
                if($images != ''){
                    $images .=",".implode(",",$filename);
                }
                $object->images = $images;
            }
        }
        $object->save();
        $id  = $object->id;
        if($request->input("tags")){
            ArticleTags::where("article_id",$id)->delete();
            $tags = $request->input("tags");
            for($i=0;$i < count($tags);$i++){
                $object2 = new ArticleTags();
                $object2->article_id = $id;
                $object2->tag_id = $tags[$i];
                $object2->save();
            }
        }
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('articles');
        $response['message'] = "Articles updated successfullyy";
        return response()->json($response);
    }
    public function deleteImage($unique_id,Request $request){
       
        $apiData['image'] = $request->get("image");
        $image = $request->input("image");
        $article = Articles::where("unique_id",$unique_id)->first();
        $images = explode(",",$article->images);
        if(file_exists(public_path('uploads/articles/'.$image))){
            unlink(public_path('uploads/articles/'.$image));
        }
        if (($key = array_search($image, $images)) !== false) {
            unset($images[$key]);
            array_values($images);
        }
        $article->images = implode(",",$images);
        $article->save();

        return redirect()->back()->with("success","Image has been deleted!");
        
    }
    public function deleteSingle($unique_id){
       
        $record = Articles::where("unique_id",$unique_id)
                            ->first();
        Articles::deleteRecord($record->id);
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('articles');
        $response['message'] = 'Article deleted successfully';
        
        return redirect()->back()->with("success","Article has been deleted!");
    }
}