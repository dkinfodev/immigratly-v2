<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

use App\Models\ScreenCapture;
use App\Models\ScreenshotHistory;
use App\Models\CaptureCategory;

require_once base_path('library/image.compare.class.php');
use CompareImages;

class ScreenCaptureController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index($category_id)
    {
        $category_id = base64_decode($category_id);
        $category = CaptureCategory::where("id",$category_id)->first();
        $viewData['category'] = $category;
        $viewData['pageTitle'] = "Screen Capture";
        return view(roleFolder().'.screen-capture.lists',$viewData);
    }

    public function getAjaxList($category_id,Request $request)
    {
        $category_id = base64_decode($category_id);
        
        $records = ScreenCapture::where('category_id',$category_id)
                                ->orderBy('id',"desc")
                                ->paginate();
        $category = CaptureCategory::where("id",$category_id)->first();
        $viewData['category'] = $category;
        $viewData['records'] = $records;
        $viewData['current_page'] = (string) $records->currentPage();
        $viewData['last_page'] = (string) $records->lastPage();
        $viewData['total_records'] = (string) $records->total();
        $view = View::make(roleFolder().'.screen-capture.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        $response['paginate'] = (string) $records->links();
        return response()->json($response);
    }

    public function addNew($category_id)
    {
        $category_id = base64_decode($category_id);
        $category = CaptureCategory::where("id",$category_id)->first();
        $viewData['category'] = $category;
        $viewData['pageTitle'] = "Add Screen Capture";
        return view(roleFolder().'.screen-capture.add',$viewData);
    }

    public function save($category_id,Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'page_name' => 'required|unique:screen_capture',
                'page_url' => 'required|unique:screen_capture',
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
            $category_id = base64_decode($category_id);
            $object = new ScreenCapture();
            $object->page_name = $request->input("page_name");
            $object->category_id = $category_id;
            $object->image_name = str_slug($request->input("page_name")).".png";
            $object->page_url = $request->input("page_url");
            $object->save();
            $id = $object->id;

            

            $response['status'] = true;
            $response['message'] = "Webpage added successfully";
            $response['redirect_back'] = baseUrl('screen-capture/'.base64_encode($category_id));
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function edit($category_id,$id)
    {
        $id = base64_decode($id);
        $category_id = base64_decode($category_id);
        $category = CaptureCategory::where("id",$category_id)->first();
        
        $record = ScreenCapture::find($id);
       
        $viewData['category'] = $category;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Edit Screen Capture";
        return view(roleFolder().'.screen-capture.edit',$viewData);
    }

    public function update($category_id,$id,Request $request){
        try{
            $id = base64_decode($id);
            $category_id = base64_decode($category_id);
            $object = ScreenCapture::find($id);
            $validator = Validator::make($request->all(), [
                'page_name' => 'required|unique:screen_capture,page_name,'.$object->id,
                'page_url' => 'required|unique:screen_capture,page_url,'.$object->id
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
            $object->page_name = $request->input("page_name");
            $object->category_id = $category_id;
            $object->image_name = str_slug($request->input("page_name")).".png";
            $object->page_url = $request->input("page_url");
            $object->save();
            
            $response['status'] = true;
            $response['redirect_back'] = baseUrl('screen-capture/'.base64_encode($category_id));
            $response['message'] = "Screen Capture edited successfully";

        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }


    public function deleteSingle($category_id,$id){
        $id = base64_decode($id);
        ScreenCapture::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }

    public function deleteMultiple($category_id,Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            ScreenCapture::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function captureScreen($category_id,$id,Request $request){
        try{
            ini_set('memory_limit', '-1');
            $id = base64_decode($id);
            $page = ScreenCapture::find($id);
            $page_url = $page->page_url;
            $image_name = $page->image_name;
            $upload_path = public_path("uploads/screen-capture");
            exec("node capture-webpage/capture.js ".$page_url." ".$image_name." ".$upload_path,$output);
            if(isset($output[0]) && $output[0] == 'success'){
                $dir = $page->id;
                $path = public_path('uploads/screen-capture/'.$dir."/");
                $source_dir = public_path('uploads/screen-capture/');
                if(!is_dir($path)){
                    // mkdir($path, "0777");
                    $result = \File::makeDirectory($path);
                }
                $new_name = $image_name."-".time().".png";

                $this->compressImage($source_dir.$image_name,$source_dir.$image_name,60);
                $existing = ScreenshotHistory::where("sc_id",$page->id)->orderBy("id","desc")->count();
                $compare = 1;
                
                if($existing > 1){
                    $last_image = ScreenshotHistory::where("sc_id",$page->id)->orderBy("id","desc")->first();
                    // $compare = imagesCompare($path.$last_image->image_name,$source_dir.$image_name);
                    $image1 = $path.$last_image->image_name;
                    $image2 = $source_dir.$image_name;
                    $obj = new compareImages();
                    $compare = $obj->compare($image1,$image2);
                }
                if($compare > 0){
                    $success = \File::copy($source_dir.$image_name,$path.$new_name);
                    $object = new ScreenshotHistory();
                    $object->sc_id = $page->id;
                    $object->image_name = $new_name;
                    $object->save();

                    $count = ScreenshotHistory::where("sc_id",$page->id)->orderBy("id","desc")->count();
                  
                    if($count > 5){
                        $get_ids = ScreenshotHistory::where("sc_id",$page->id)
                                    ->limit(5)
                                    ->orderBy("id","desc")
                                    ->pluck('id')
                                    ->toArray();
                       
                        $last_id = end($get_ids);
                       
                        $old_images = ScreenshotHistory::where("sc_id",$page->id)
                                        ->where("id","<",$last_id)
                                        ->get();
                        foreach($old_images as $image){
                            if(file_exists($path.$image->image_name) && unlink($path.$image->image_name)){
                                ScreenshotHistory::where("id",$image->id)->delete();
                            }
                        }
                    }
                }
                $response['status'] = true;
                $response['message'] = "Screen captured successfully";
                $response['redirect_url'] = baseUrl("screen-capture/".$category_id."/history/".base64_encode($id));
            }else{
                // echo "failed\n".$page_url."\n".$image_name;
                $response['status'] = false;
                $response['message'] = "Failed capturing latest update";
            }

        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    function compressImage($source, $destination, $quality) {
        if(file_exists($source)){
            $info = getimagesize($source);
            if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);

            imagejpeg($image, $destination, $quality);
        }
    }

    public function history($category_id,$id)
    {
        $id = base64_decode($id);
        $category_id = base64_decode($category_id);
        $category = CaptureCategory::where("id",$category_id)->first();
        ScreenshotHistory::where("sc_id",$id)->update(['is_read'=>1]);
        $viewData['category'] = $category;
        $screen_capture = ScreenCapture::find($id);
        $viewData['screen_capture'] = $screen_capture;
        $records = ScreenshotHistory::with('ScreenCapture')->where("sc_id",$id)->orderBy('created_at','desc')->get();
        $viewData['screenhistory'] = $records;
        $viewData['pageTitle'] = "Screen Capture History";
        return view(roleFolder().'.screen-capture.history',$viewData);
    }

    // public function addComment($id){
    //     try{
    //         $id =base64_decode($id);
    //         $comments = ScreenshotComments::where("sc_id",$id)->get();
    //         $viewData['comments'] = $comments;
    //         $viewData['id'] = $id;
    //         $view = View::make(roleFolder().'.screen-capture.modal.add-comment',$viewData);
    //         $contents = $view->render();
    //         $response['status'] = true;
    //         $response['contents'] = $contents;
    //     } catch (Exception $e) {
    //         $response['status'] = false;
    //         $response['message'] = $e->getMessage();
    //     }
    //     return response()->json($response);
    // }

    // public function saveComment($id,Request $request){
    //     try{
    //         $validator = Validator::make($request->all(), [
    //             'comment' => 'required'
    //         ]);

    //         if ($validator->fails()) {
    //             $response['status'] = false;
    //             $error = $validator->errors()->toArray();
    //             $errMsg = '';
    //             foreach($error as $err){
    //                 $errMsg .= $err[0];
    //             }
    //             $response['message'] = $errMsg;
    //             return response()->json($response);
    //         }
    //         $id = base64_decode($id);
    //         $object = new ScreenshotComments();
    //         $object->sc_id = $id;
    //         $object->comment = $request->input("comment");
    //         $object->added_by = \Auth::user()->id;
    //         $object->save();

    //         $response['status'] = true;
    //         $response['message'] = "Added added successfully";
    //     } catch (Exception $e) {
    //         $response['status'] = false;
    //         $response['message'] = $e->getMessage();
    //     }
    //     return response()->json($response);
    // }

    // public function deleteComment($id){
    //     try{
    //         $id = base64_decode($id);
    //         ScreenshotComments::where("id",$id)->delete();
    //         $response['status'] = true;
    //         $response['message'] = "Comment deleted successfully";
    //     } catch (Exception $e) {
    //         $response['status'] = false;
    //         $response['message'] = $e->getMessage();
    //     }
    //     return response()->json($response);
    // }
    
    public function deleteScreenHistory($id,$history_id){
        $history_id = base64_decode($history_id);
        ScreenshotHistory::deleteRecord($history_id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
}
