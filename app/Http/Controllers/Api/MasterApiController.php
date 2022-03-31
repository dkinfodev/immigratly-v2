<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

use App\Models\User;
use App\Models\UserWithProfessional;
use App\Models\DomainDetails;
use App\Models\ProfessionalPrivileges;
use App\Models\PrivilegesActions;
use App\Models\Roles;
use App\Models\UserDetails;
use App\Models\Articles;
use App\Models\ArticleTags;
use App\Models\Webinar;
use App\Models\WebinarTags;
use App\Models\WebinarTopics;
use App\Models\Assessments;
use App\Models\AssessmentDocuments;
use App\Models\VisaServices;
use App\Models\DocumentFolder;
use App\Models\AsssessmentNotes;
use App\Models\AssessmentReports;
use App\Models\AssessmentForms;
use App\Models\ExternalAssessments;
use App\Models\BookedAppointments;
use App\Models\UserInvoices;
use App\Models\InvoiceItems;

class MasterApiController extends Controller
{
	var $subdomain;
    public function __construct(Request $request)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        \Config::set('database.connections.mysql.database', MAIN_DATABASE);
    	$headers = $request->header();
        $this->subdomain = $headers['subdomain'][0];
        
        // $this->middleware('curl_api');
        // $this->subdomain = "fastzone";
    }
    public function createClient(Request $request)
    {
    	try{
    		$postData = $request->input();
            $request->request->add($postData);
            $password = "demo@123";
            $user = $postData['data'];
            $professional = $postData['professional'];
            $checkExists = User::where("email",$user['email'])
                                // ->where("phone_no",$user['phone_no'])
                                ->first();
            $is_exists = 0;
            if(!empty($checkExists)){
                // $response['status'] = 'error';
                // $response['error'] = "email_exists";
                // $response['message'] = "Client account with email ".$user['email']." and ".$user['phone_no']." already exists";
                // return response()->json($response);
                $is_exists = 1;
                $unique_id = $checkExists->unique_id;
            }

            // $checkExists = User::where("email",$user['email'])->first();
            // $is_exists = 0;
            // if(!empty($checkExists)){
            // 	$response['status'] = 'error';
            // 	$response['error'] = "email_exists";
            // 	$response['message'] = "Client account with email ".$user['email']." already exists";
            //     $is_exists = 1;
            //     $unique_id = $checkExists->unique_id;
        	// 	// return response()->json($response);
            // }

            
            if($is_exists == 0){
                $checkExists = User::where("phone_no",$user['phone_no'])->first();
                if(!empty($checkExists) && $is_exists == 0){
                    $response['status'] = 'error';
                    $response['error'] = "phone_exists";
                    $response['message'] = "Phone no already exists";
                    return response()->json($response);
                }
                $unique_id = randomNumber();
    	       	$object = new User();
    	        $object->first_name = $user['first_name'];
    	        $object->last_name = $user['last_name'];
    	        $object->email =  $user['email'];
    	        $object->password = bcrypt($password);
    	        $object->country_code = $user['country_code'];
    	        $object->phone_no = $user['phone_no'];
                
    	        $object->role = "user";
                $object->unique_id = $unique_id;
    	        $object->is_active = 1;
    	        $object->is_verified = 1;
    	        $object->save();

    	        $user_id = $object->id;

                $object = new UserDetails();
                $object->user_id = $unique_id;
                if(isset($user['date_of_birth'])){
                    $object->date_of_birth = $user['date_of_birth'];
                }
                if(isset($user['gender'])){
                    $object->gender = $user['gender'];
                }
                if(isset($user['country_id'])){
                    $object->country_id = $user['country_id'];
                }
                if(isset($user['state_id'])){
                    $object->state_id = $user['state_id'];
                }
                if(isset($user['city_id'])){
                    $object->city_id = $user['city_id'];
                }
                if(isset($user['address'])){
                    $object->address = $user['address'];
                }
                if(isset($user['zip_code'])){
                    $object->zip_code = $user['zip_code'];
                }
                $object->save();
                $response['user_exists'] = 0;
            }else{
                $response['user_exists'] = 1;
            }
            $checkExists = UserWithProfessional::where("user_id",$unique_id)->where("professional",$this->subdomain)->first();
            if(empty($checkExists)){
                $object2 = new UserWithProfessional();
                $object2->user_id = $unique_id;
                $object2->professional= $this->subdomain;
                $object2->status = 1;
                $object2->save();
            }

	        $response['user_id'] = $unique_id;
	        $response['post_data'] = $postData;
            if($is_exists == 0){
	            $response['message'] = "Client has been created successfully";
            }else{
                $response['message'] = "Client already exits so it is linked";
            }
	        $response['status'] = 'success';

            if($is_exists == 0){
                $mailData = array();
                $mail_message = "Hello ".$user['first_name']." ".$user['last_name'].",<Br> Your account has been created in ".companyName()." by ".$professional['company_name'].". Case has been created.";
                $mail_message .= "<br> You login details are as below:";
                $mail_message .= "<br> <b>Email: </b>".$user['email'];
                $mail_message .= "<br> <b>Password: </b>".$password;
                $mail_message .= "<br> <b>Site Url: </b>".site_url();
                $parameter['subject'] = "Account has been created in ".companyName();
            }else{
                $mailData = array();
                $mail_message = "Hello ".$user['first_name']." ".$user['last_name'].",<br>".$professional['company_name']." has created the case. Please login to the panel and check it.";
                $parameter['subject'] = "New case added to your profile";
            }
            $mailData['mail_message'] = $mail_message;
            $view = View::make('emails.notification',$mailData);
            
            $message = $view->render();
            $parameter['to'] = $user['email'];
            $parameter['to_name'] = $user['first_name']." ".$user['last_name'];
            $parameter['message'] = $message;
            
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);

            $sms_message = $mail_message;
            $to_no = $user['country_code'].$user['phone_no'];
            sendSms($to_no,$sms_message);
            
       	} catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function roles(Request $request){
        try{
            $avoid = array("admin","user");
            $roles = Roles::whereNotIn("slug",$avoid)->get();
            $data = $roles;

            $response['status'] = 'success';
            $response['data'] = $data;


        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function privilegesList(Request $request){
        try{
            $privileges = ProfessionalPrivileges::with("Actions")->get();
            $data = $privileges;

            $response['status'] = 'success';
            $response['data'] = $data;


        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchArticles(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $records = Articles::with(['Category'])
                            ->where("professional",$this->subdomain)
                            ->where(function($query) use($search){
                                if($search != ''){
                                    $query->where("title","LIKE","%$search%");
                                }
                            })
                            ->where("status",$request->input("status"))
                            ->orderBy("id","desc")
                            ->paginate();
            
            foreach($records as $record){
                $record->professional_info = $record->ProfessionalDetail($record->professional);
            }
            $data = $records;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function saveArticle(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            
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
            // $object->status = $request->input("status");
            // if($request->input("content_block")){
            //     $object->content_block = $request->input("content_block");
            // }
            $object->professional= $this->subdomain;
            $object->added_by = $request->input("added_by");
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
            $response['status'] = 'success';
            $response['message'] = "Article saved successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteArticle(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $record = Articles::where("professional",$this->subdomain)
                            ->where("unique_id",$request->input("article_id"))
                            ->first();
            Articles::deleteRecord($record->id);
            $response['status'] = 'success';
            $response['message'] = 'Article deleted successfully';

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function deleteArticleImage(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $image = $request->input("image");
            $article = Articles::where("unique_id",$request->input("article_id"))->first();
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

            $response['status'] = 'success';
            $response['message'] = "Article image removed successfully";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function articlesCount(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $publish = Articles::with(['Category','ArticleTags'])
                            ->where("professional",$this->subdomain)
                            ->where("status","publish")
                            ->count();
            
            $draft = Articles::with(['Category','ArticleTags'])
                            ->where("professional",$this->subdomain)
                            ->where("status","draft")
                            ->count();
            $data['publish'] = $publish;
            $data['draft'] = $draft;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function fetchArticle(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $record = Articles::with(['Category','ArticleTags'])
                            ->where("professional",$this->subdomain)
                            ->where("unique_id",$request->input("article_id"))
                            ->first();
          
            $data = $record;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function updateArticle(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $article_id = $request->input("article_id");
            $object = Articles::where('unique_id',$article_id)
                                ->where("professional",$this->subdomain)
                                ->first();
            $images = $object->images;
            $check_name_count = Articles::where("title",$request->input('title'))
                                        ->where("unique_id","!=",$article_id)
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
            $object->professional= $this->subdomain;
            $object->added_by = $request->input("added_by");
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
            $response['status'] = 'success';
            $response['message'] = "Article saved successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    
    public function saveWebinar(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            
            $unique_id = randomNumber();
            $check_name_count = Webinar::where("title",$request->input('title'))->count();
            $slug = str_slug($request->input("title"));
            if($check_name_count > 0){
                $slug = $slug."-".($check_name_count+1);
            }
            $object = new Webinar();
            $object->unique_id = $unique_id;
            $object->title = $request->input("title");
            $object->slug = $slug;
            $object->description = $request->input("description");
            $object->short_description = $request->input("short_description");
            $object->category_id = $request->input("category_id");
            $object->level = $request->input("level");
            $object->webinar_date = $request->input("webinar_date");
            $object->start_time = $request->input("start_time");
            $object->end_time = $request->input("end_time");
            $object->total_seats = $request->input("total_seats");
            $object->level = $request->input("level");
            $object->language_id = $request->input("language_id");
            if($request->input("paid_event")){
                $object->paid_event = 1;
                $object->event_cost = $request->input("event_cost");
                $object->price_group = $request->input("price_group");
            }else{
                $object->paid_event = 0;
                $object->event_cost = 0;
                $object->price_group = '';
            }

            if($request->input("offline_event")){
                $object->offline_event = 1;
                $object->address = $request->input("address");
                $object->country_id = $request->input("country_id");
                $object->state_id = $request->input("state_id");
                $object->city_id = $request->input("city_id");
                $object->online_event_link = '';
            }else{
                $object->offline_event = 0;
                $object->address = '';
                $object->country_id = 0;
                $object->state_id = 0;
                $object->city_id = 0;
                $object->online_event_link = $request->input("online_event_link");
            }
            $object->status = 'publish';

            $object->professional= $this->subdomain;
            $object->added_by = $request->input("added_by");
            if($request->input("timestamp")){
                $timestamp = $request->input("timestamp");
                if(is_dir(public_path()."/uploads/temp/". $timestamp)){
                    $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
                    $filename = array();
                    for($f = 0; $f < count($files);$f++){
                        $file_arr = explode("/",$files[$f]);
                        $filename[] = end($file_arr);
                        $file_name =  end($file_arr);
                        $destinationPath = public_path("/uploads/webinars/".$file_name);
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
            }
            $object->save();
            $id  = $object->id;
            if($request->input("tags")){
                $tags = $request->input("tags");
                for($i=0;$i < count($tags);$i++){
                    $object2 = new WebinarTags();
                    $object2->webinar_id = $id;
                    $object2->tag_id = $tags[$i];
                    $object2->save();
                }
            }
            if($request->input("topics")){
                $topics = $request->input("topics");
                foreach($topics as $topic){
                    $object2 = new WebinarTopics();
                    $object2->webinar_id = $id;
                    $object2->topic_name = $topic['topic_name'];
                    $object2->topic_list = implode(",",$topic['topic_list']);
                    $object2->save();
                }
            }
            $response['status'] = 'success';
            $response['message'] = "Webinar saved successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchWebinars(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $records = Webinar::with(['Category'])
                            ->where("professional",$this->subdomain)
                            ->where(function($query) use($search){
                                if($search != ''){
                                    $query->where("title","LIKE","%$search%");
                                }
                            })
                            ->where("status",$request->input("status"))
                            ->orderBy("id","desc")
                            ->paginate();
            
            foreach($records as $record){
                $record->professional_info = $record->ProfessionalDetail($record->professional);
            }
            $data = $records;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchWebinar(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $record = Webinar::with(['Category','WebinarTags','WebinarTopics'])
                            ->where("professional",$this->subdomain)
                            ->where("unique_id",$request->input("webinar_id"))
                            ->first();
          
            $data = $record;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function updateWebinar(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $webinar_id = $request->input("webinar_id");
            $check_name_count = Webinar::where("title",$request->input('title'))
                                        ->where("unique_id",$webinar_id)
                                        ->count();
            $slug = str_slug($request->input("title"));
            if($check_name_count > 0){
                $slug = $slug."-".($check_name_count+1);
            }
            $object = Webinar::where("unique_id",$webinar_id)->first();
            $images = $object->images;
            $object->title = $request->input("title");
            $object->slug = $slug;
            $object->description = $request->input("description");
            $object->short_description = $request->input("short_description");
            $object->category_id = $request->input("category_id");
            $object->level = $request->input("level");
            $object->webinar_date = $request->input("webinar_date");
            $object->start_time = $request->input("start_time");
            $object->end_time = $request->input("end_time");
            $object->total_seats = $request->input("total_seats");
            $object->level = $request->input("level");
            $object->language_id = $request->input("language_id");
            if($request->input("paid_event")){
                $object->paid_event = 1;
                $object->event_cost = $request->input("event_cost");
                $object->price_group = $request->input("price_group");
            }else{
                $object->paid_event = 0;
                $object->event_cost = 0;
                $object->price_group = '';
            }

            if($request->input("offline_event")){
                $object->offline_event = 1;
                $object->address = $request->input("address");
                $object->country_id = $request->input("country_id");
                $object->state_id = $request->input("state_id");
                $object->city_id = $request->input("city_id");
                $object->online_event_link = '';
            }else{
                $object->offline_event = 0;
                $object->address = '';
                $object->country_id = 0;
                $object->state_id = 0;
                $object->city_id = 0;
                $object->online_event_link = $request->input("online_event_link");
            }
            if($request->input("timestamp")){
                $timestamp = $request->input("timestamp");
                if(is_dir(public_path()."/uploads/temp/". $timestamp)){
                    $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
                    $filename = array();
                    for($f = 0; $f < count($files);$f++){
                        $file_arr = explode("/",$files[$f]);
                        $filename[] = end($file_arr);
                        $file_name =  end($file_arr);
                        $destinationPath = public_path("/uploads/webinars/".$file_name);
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
            }
            $object->save();
            $id  = $object->id;
            if($request->input("tags")){
                WebinarTags::where("webinar_id",$id)->delete();
                $tags = $request->input("tags");
                for($i=0;$i < count($tags);$i++){
                    $object2 = new WebinarTags();
                    $object2->webinar_id = $id;
                    $object2->tag_id = $tags[$i];
                    $object2->save();
                }
            }
            if($request->input("topics")){
                $topics = $request->input("topics");
                WebinarTopics::where("webinar_id",$id)->delete();
                foreach($topics as $topic){
                    $object2 = new WebinarTopics();
                    $object2->webinar_id = $id;
                    $object2->topic_name = $topic['topic_name'];
                    $object2->topic_list = implode(",",$topic['topic_list']);
                    $object2->save();
                }
            }
            $response['status'] = 'success';
            $response['message'] = "Webinar updated successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteWebinar(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $record = Webinar::where("professional",$this->subdomain)
                            ->where("unique_id",$request->input("webinar_id"))
                            ->first();
            Webinar::deleteRecord($record->id);
            $response['status'] = 'success';
            $response['message'] = 'Webinar deleted successfully';

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function deleteWebinarImage(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $image = $request->input("image");
            $record = Webinar::where("unique_id",$request->input("webinar_id"))->first();
            $images = explode(",",$record->images);
            if(file_exists(public_path('uploads/webinars/'.$image))){
                unlink(public_path('uploads/webinars/'.$image));
            }
            if (($key = array_search($image, $images)) !== false) {
                unset($images[$key]);
                array_values($images);
            }
            $record->images = implode(",",$images);
            $record->save();

            $response['status'] = 'success';
            $response['message'] = "Webinar image removed successfully";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function assessments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $records = Assessments::with(['VisaService','Client','Invoice','AssessmentDocuments'])
                        ->orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("assessment_title","LIKE","%$search%");
                            }
                        })
                        ->whereHas("VisaService")
                        ->where("professional",$request->input("subdomain"))
                        ->whereHas("Invoice",function($query) use($search){
                            $query->where("payment_status","paid");
                        })
                        ->paginate();
           
            $response['status'] = 'success';
            $response['data'] = $records->items();
            $response['records'] = $records;
            $response['last_page'] = $records->lastPage();
            $response['current_page'] = $records->currentPage();
            $response['total_records'] = $records->total();
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
        
    }

    public function assessmentDetail(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $assessment_id = $request->input("assessment_id");
            $record = Assessments::with(['VisaService','Client','Invoice','AssessmentDocuments'])->orderBy('id',"desc")
                        ->where("professional",$request->input("subdomain"))
                        ->where("unique_id",$assessment_id)
                        ->first();
            if(!empty($record)){
                if($request->input("mark_as_read")){
                    if($record->professional_read == 0){
                        $object = Assessments::find($record->id);
                        $object->professional_read = 1;
                        $object->save();
                    }
                }
                $document_folders = array();
                
                if($record->visa_service_id != ''){
                    $vs = VisaServices::where("unique_id",$record->visa_service_id)->first();
                    if(!empty($vs)){
                        $document_folders = $vs->DocumentFolders($vs->id);
                    }
                }
                $response['document_folders'] = $document_folders;
                $response['status'] = true;
                $response['data'] = $record;
            }else{
                $response['status'] = "error";
                $response['message'] = "Invalid asssessment";    
            }
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchAssessmentDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $assessment_id = $request->input("assessment_id");
            $folder_id = $request->input("folder_id");
            $user_id = $request->input("user_id");
            
            $folder = DocumentFolder::where("unique_id",$folder_id)->first();
            $documents = AssessmentDocuments::with('FileDetail')->orderBy('id',"desc")
                                        ->where("user_id",$user_id)
                                        ->where("assessment_id",$assessment_id)
                                        ->where("folder_id",$folder_id)
                                        ->get();
            $assessment = Assessments::where("unique_id",$assessment_id)->first();
            $user_details = UserDetails::where("user_id",$user_id)->first();

            $data['documents'] = $documents;
            $data['assessment'] = $assessment;
            $data['folder'] = $folder;
            
            $data['user_details'] = $user_details;
            $file_dir = userDir($user_id)."/documents";
            $file_url = userDirUrl($user_id)."/documents";
            $data['file_dir'] = $file_dir;
            $data['file_url'] = $file_url;

            $response['data'] = $data;
            $response['status'] = "success";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);   
    }
    public function fetchAssessmentReport(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $data = AssessmentReports::where("assessment_id",$request->input("assessment_id"))->first();
            
            $response['data'] = $data;
            $response['status'] = "success";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);   
    }
    public function saveAssessmenReport(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $check_report = AssessmentReports::where("assessment_id",$request->input("assessment_id"))->first();
            if(!empty($check_report)){
                $object = AssessmentReports::find($check_report->id);
            }else{
                $object = new AssessmentReports();
            }
            $object->assessment_id = $request->input("assessment_id");
            $object->case_review = $request->input("case_review");
            $object->strength_of_case = $request->input("strength_of_case");
            $object->weakness_of_case = $request->input("weakness_of_case");
            $object->case_quality = $request->input("case_quality");
            $object->case_type = $request->input("case_type");
            $object->added_by = $request->input("added_by");
            $object->save();
            
            $response['message'] = "Assessment report saved";
            $response['status'] = "success";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);   
    }
    
    public function assessmentForms(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $records = AssessmentForms::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("form_title","LIKE","%$search%");
                            }
                        })
                        ->where("assessment_id",$request->input("assessment_id"))
                        ->paginate();
            $response['status'] = true;
            $response['data'] = $records->items();
            $response['last_page'] = $records->lastPage();
            $response['current_page'] = $records->currentPage();
            $response['total_records'] = $records->total();
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
        
    }

    public function saveAssessmentForm(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $object = new AssessmentForms();
            $object->unique_id = randomNumber();
            $object->uuid = generateUUID();
            $object->assessment_id = $request->input("assessment_id"); 
            $object->form_title = $request->input("form_title");
            $object->form_json = $request->input("form_json");
            $object->added_by = $request->input("added_by");
            $object->professional = $request->input("subdomain");
            $object->save();

            $response['status'] = "success";
            $response['message'] = "Form saved";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchAssessmentForm(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $form_id = $request->input("form_id");
            $record = AssessmentForms::where("unique_id",$form_id)->first();
            $response['status'] = "success";
            $response['data'] = $record;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function updateAssessmentForm(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            
            $object = AssessmentForms::where('unique_id',$request->input("form_id"))->first();
            $object->assessment_id = $request->input("assessment_id"); 
            if($object->uuid == ''){
                $object->uuid = generateUUID();
            }
            $object->form_title = $request->input("form_title");
            $object->form_json = $request->input("form_json");
            $object->professional = $request->input("subdomain");
            $object->save();

            $response['status'] = "success";
            $response['message'] = "Form saved";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteAssessment(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $action = $request->input("action");
            if($action == 'multiple'){
                $ids = explode(",",$request->input("ids"));
            }else{
                $ids[] = $request->input("id");
            }
            
            for($i = 0;$i < count($ids);$i++){
                $id = $ids[$i];
                $assessment = AssessmentForms::where("unique_id",$id)->first();
                AssessmentForms::deleteRecord($assessment->id);
            }
            $response['status'] = "success";
            $response['message'] = "Form deleted";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function externalAssessments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
           
            $records = ExternalAssessments::where("lead_id",$request->input("lead_id"))
                      ->whereHas("Assessment")
                      ->with(["Assessment","AssessmentForm"])
                      ->paginate();
            
            $response['status'] = "success";
            $response['data'] = $records->items();
            $response['last_page'] = $records->lastPage();
            $response['current_page'] = $records->currentPage();
            $response['total_records'] = $records->total();
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function viewExternalAssessment(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
           
            $records = ExternalAssessments::where("unique_id",$request->input("form_id"))
                      ->whereHas("Assessment")
                      ->with(["Assessment","AssessmentForm"])
                      ->first();
            
            $response['status'] = "success";
            $response['data'] = $records;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function bookedAppointments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $records = BookedAppointments::with(['Client'])
                        ->orderBy('appointment_date',"desc")
                        // ->where(function($query) use($search){
                        //     if($search != ''){
                        //         $query->where("assessment_title","LIKE","%$search%");
                        //     }
                        // })
                        ->where("professional",$request->input("subdomain"))
                        ->whereHas("Client")
                        ->paginate();
           
            $response['status'] = 'success';
            $response['data'] = $records->items();
            $response['records'] = $records;
            $response['last_page'] = $records->lastPage();
            $response['current_page'] = $records->currentPage();
            $response['total_records'] = $records->total();
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
        
    }

    public function changeBookingStatus(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $status = $request->input("status");
            $id = $request->input("id");

            BookedAppointments::where('unique_id',$id)->update(["status"=>$status]);

            $response['status'] = "success";
            $response['message'] = "Booking status changed";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchAppointments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $location_id = '';
            if($request->input("location_id")){
                $location_id = $request->input("location_id");
            }
            if($request->input("response_type") == 'date_counter'){
                $records = BookedAppointments::where("appointment_date",">=",$request->input("start_date"))
                    ->where("appointment_date","<=",$request->input("end_date"))
                    ->where("professional",$request->input("professional"))
                    ->where(function($query) use($location_id){
                        if($location_id != ''){
                            $query->where("location_id",$location_id);
                        }
                    })
                    ->whereHas("Client")
                    ->orderBy('appointment_date',"desc")
                    ->groupBy("appointment_date")
                    ->select(\DB::raw("COUNT(id) as total_appointment,appointment_date"))
                    ->get();
            }else{
                $records = BookedAppointments::with(['Client'])
                    ->where("appointment_date",$request->input("start_date"))
                    ->where("appointment_date",$request->input("end_date"))
                    ->where("professional",$request->input("professional"))
                    ->where(function($query) use($location_id){
                        if($location_id != ''){
                            $query->where("location_id",$location_id);
                        }
                    })
                    ->whereHas("Client")
                    ->orderBy('appointment_date',"desc")
                    ->get();
            }
           
            $response['status'] = 'success';
            $response['data'] = $records;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
        
    }

    public function appointmentDetail(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $appointment_id = $request->input("appointment_id");

            $appointment = BookedAppointments::with(['Client'])->where("unique_id",$appointment_id)->first();
            $response['status'] = 'success';
            $response['data'] = $appointment;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function updateAppointment(Request $request){

        try{
            $postData = $request->input();
            $request->request->add($postData);
            $duration = explode("-",$request->input("duration"));
            
            
            if($request->input("action") == 'edit'){
                $object = BookedAppointments::where("unique_id",$request->input("eid"))->first();
                $appointment = $object;
                $booking_id = $object->unique_id;
                $object->edit_counter = $object->edit_counter+1;
            }else{
                $appointment = array();
                $booking_id = randomNumber();
                $inv_unique_id = randomNumber();
                $object = new BookedAppointments();
                $object->unique_id = $booking_id;
            }
            
            
            $object->professional = $request->input("professional");
            $object->location_id = $request->input("location_id");
            $object->break_time = $request->input("break_time");
            
            $object->visa_service_id = $request->input("visa_service");
            $object->appointment_date = $request->input("date");
            $object->appointment_type_id = $request->input("appointment_type_id");
            $object->status = 'awaiting';
            if($request->input("price") > 0){
                $object->payment_status = 'pending';
            }else{
                $object->payment_status = 'paid';
            }
            $object->schedule_id = $request->input("schedule_id");
            $object->time_type = $request->input("time_type");
            
            $object->price = $request->input("price");
            $object->meeting_duration = $request->input("interval");
            $object->start_time = $duration[0];
            $object->end_time = $duration[1];
            if($request->input("action") == 'add'){
                $object->invoice_id = $inv_unique_id;
            }
            $object->save();

                    
            if($request->input("action") == 'edit'){
                $object2 = UserInvoices::where("link_id",$booking_id)->where("link_to","appointment")->first();
                $inv_unique_id = $object2->unique_id;
            }else{
                $object2 = new UserInvoices();
                $object2->unique_id = $inv_unique_id;
            }
            $object2->payment_status = "pending";
            $object2->amount = $request->input("price");
            $object2->link_to = 'appointment';
            $object2->link_id = $booking_id;
            $object2->invoice_date = date("Y-m-d"); 
            $object2->save();

            if($request->input("action") == 'edit'){
                $object2 = InvoiceItems::where("invoice_id",$inv_unique_id)->first();
            }else{
                $object2 = new InvoiceItems();
                $object2->invoice_id = $inv_unique_id;
                $object2->unique_id = randomNumber();
            }
            
            $object2->particular = "Appointment Fee";
            $object2->amount = $request->input("price");
            $object2->save();

            $response['status'] = 'success';
            $response['message'] = "Appointment reschedule successfully";
            
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
}
