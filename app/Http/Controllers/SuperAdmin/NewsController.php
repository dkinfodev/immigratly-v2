<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\VisaServices;
use App\Models\News;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function news()
    {
        $viewData['activeTab'] = "news";
        $viewData['pageTitle'] = "News";
        return view(roleFolder().'.news.lists',$viewData);
    }

    
    public function getAjaxList(Request $request)
    {   
        $search = $request->input("search");
        $records = News::where(function($query) use($search){
                            if($search != ''){
                                $query->where("title","LIKE","%".$search."%");
                            }
                        })
                        ->orderBy('id',"desc")
                        ->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.news.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add News";
        $viewData['activeTab'] = "news";
        $viewData['categories'] = VisaServices::get();
        return view(roleFolder().'.news.add',$viewData);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description'=> 'required',
            'news_category'=> 'required',
            'news_date' => 'required',
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
        $object =  new News();

        $object->title = $request->input("title");

        
        $object->description = $request->input("description");
        $object->category_id = $request->input("news_category");
        $object->news_date = $request->input("news_date");
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('news');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = News::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit News";
        $viewData['activeTab'] = "news";
        $viewData['categories'] = VisaServices::get();
        return view(roleFolder().'.news.edit',$viewData);
    }

    public function update(Request $request){
        $id = $request->input("id");
        $id = base64_decode($id);

        $object =  News::find($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description'=> 'required',
            'news_category'=> 'required',
            'news_date' => 'required',
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
        
        $object->title = $request->input("title");
        $object->description = $request->input("description");
        $object->category_id = $request->input("news_category");
        $object->news_date = $request->input("news_date");
        $object->added_by = \Auth::user()->id;

        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('news');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        News::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            News::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }


    public function newsCategory()
    {
        $viewData['pageTitle'] = "News Category";
        $viewData['activeTab'] = "news";
        return view(roleFolder().'.news-category.lists',$viewData);
    } 

    public function newsCategoryGetAjaxList(Request $request){
        
        $search = $request->input("search");
        $records = NewsCategory::
                        where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%".$search."%");
                            }
                        })
                        ->orderBy('id',"desc")
                        ->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.news-category.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
    public function newsCategoryAdd(){
        $viewData['pageTitle'] = "Add News Category";
        $view = View::make(roleFolder().'.news-category.modal.add',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function newsCategorySave(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:news_category,name',    
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

        $object =  new NewsCategory;
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->added_by = \Auth::user()->id;
        
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('news-category');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }

    public function newsCategoryEdit($id){
        $id = base64_decode($id);
        $viewData['record'] = NewsCategory::where('id',$id)->first();
        $viewData['pageTitle'] = "Edit News Category";
        $view = View::make(roleFolder().'.news-category.modal.edit',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response); 
    }

    public function newsCategoryUpdate(Request $request){
        $id = $request->input('id');
        $id = base64_decode($id);

        $object = NewsCategory::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:news_category,name,'.$object->id,   
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
        $response['redirect_back'] = baseUrl('news-category');
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function newsCategoryDeleteSingle($id){
        $id = base64_decode($id);
        NewsCategory::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    public function newsCategoryDeleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            NewsCategory::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    
}
