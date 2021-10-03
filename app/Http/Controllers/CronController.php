<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

use DB;


use App\Models\BackupSettings;
use App\Models\User;
use App\Models\FilesManager;
use App\Models\ScreenCapture;
use App\Models\ScreenshotHistory;

require_once base_path('library/image.compare.class.php');
require_once base_path('library/scrapping/class.Diff.php');
require_once base_path('library/scrapping/simplehtmldom/simple_html_dom.php');

use CompareImages;

class CronController extends Controller
{
    public function __construct(Request $request)
    {
    	
    }
    public function captureScreen(Request $request){
        try{
            ini_set('memory_limit', '-1');
            $pages = ScreenCapture::get(); 
            foreach($pages as $page){

                $page_url = $page->page_url;
                $image_name = $page->image_name;
                $upload_path = public_path("uploads/screen-capture");
                $output =array();
                exec("node capture-webpage/capture.js ".$page_url." ".$image_name." ".$upload_path,$output);
                if(isset($output[0]) && $output[0] == 'success'){
                // if(shell_exec("phantomjs screencapture.js ".$page_url." ".$image_name."  2>&1")){
                
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
                    
                }else{
                    // echo "failed\n".$page_url."\n".$image_name;
                    $response['status'] = false;
                    $response['message'] = "Faile capturing latest update";
                }
            }

        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        // return response()->json($response);
    }
    public function backupFilesToGdrive(){
        $back_settings = BackupSettings::where('gdrive_duration',"!=","none")->get();
        foreach($back_settings as $setting){
            $user = User::where('unique_id',$setting->user_id)->first();
            if(!empty($user)){
               
                $last_sync_time = $setting->gdrive_last_sync;
                $current_date = date("Y-m-d");
                $flag = 0;
                if($last_sync_time != ''){
                    if($setting->gdrive_duration == 'daily'){
                        $last_sync_date = date("Y-m-d",strtotime($last_sync_time));
                        $diff = date_difference($last_sync_time,$current_date);
                        if($diff > 0){
                            $flag = 1;
                        }
                    }
                    
                    if($setting->gdrive_duration == 'weekly'){
                        $week_day = date('l', strtotime($current_date));
                        $week_day = strtolower($week_day);
                        if($week_day  == 'sunday'){
                            $flag = 1;
                        }
                    }

                    if($setting->gdrive_duration == 'montly'){
                        $last_date = date("Y-m-t", strtotime($current_date));;
                        if($current_date  == $last_date){
                            $flag = 1;
                        }
                    }
                    
                }else{
                    $flag = 1;
                }
                if($flag == 1){
                    if($setting->gdrive_parent_folder != ''){
                        $gdrive_parent_folder = $setting->gdrive_parent_folder;
                    }else{
                        $gdrive_parent_folder = create_gdrive_folder("immigratly");
                    }
                    $user_files = FilesManager::where("user_id",$user->unique_id)
                                            ->where(function($query) use($last_sync_time){
                                                if($last_sync_time != ''){
                                                    $query->whereDate("created_at",">=",$last_sync_time);
                                                }
                                            })
                                            ->limit(5)
                                            ->get();
                    
                    foreach($user_files as $file){
                        $file_path = userDir($file->user_id)."/documents/".$file->file_name;
                        if(file_exists($file_path)){
                        
                            $is_success = gdrive_file_export($file_path,$file->original_name,$gdrive_parent_folder);
                            if($is_success){
                                echo "<h1>Success</h1> File Uploaded Successfully <Br>";
                            }else{
                                echo "<h1>Error</h1> File Uploaded Failed <Br>";
                            }
                        }
                    }
                    $last_sync_time = date("Y-m-d H:i:s");
                    $update['gdrive_last_sync'] = $last_sync_time;
                    BackupSettings::where("id",$setting->id)->update($update);
                }
            }
        }
        
    }

    function compressImage($source, $destination, $quality) {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg') 
          $image = imagecreatefromjpeg($source);
  
        elseif ($info['mime'] == 'image/gif') 
          $image = imagecreatefromgif($source);
  
        elseif ($info['mime'] == 'image/png') 
          $image = imagecreatefrompng($source);
  
        imagejpeg($image, $destination, $quality);
      }

      public function scrape(){
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.ontario.ca/page/oinp-express-entry-notifications-interest');
        echo $crawler->html();
        // $dom = file_get_html('https://www.welcomebc.ca/Immigrate-to-B-C/B-C-Provincial-Nominee-Program/News', false);
        // echo $dom;
        // exit;

      }

}
