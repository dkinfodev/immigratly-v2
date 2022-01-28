<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\Webinar;
use App\Models\WebinarTags;
use App\Models\WebinarTopics;

class WebinarController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }
    public function index()
    {
       	$viewData['pageTitle'] = "Webinar";
        
        $viewData['activeTab'] = "webinar";
        $viewData['status'] = 'publish';
        return view(roleFolder().'.webinar.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = Webinar::with(['Category','ProfessionalInfo'])
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("title","LIKE","%$search%");
                            }
                        })
                        ->whereHas("ProfessionalInfo")
                        ->whereHas("Category")
                        ->orderBy("id","desc")
                        ->paginate();

        foreach($records as $record){
            $record->professional_info = $record->ProfessionalDetail($record->professional);
        }

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.webinar.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        
        return response()->json($response);
    }

    public function add(){

        $viewData['pageTitle'] = "Add Webinar";
        $services = DB::table(MAIN_DATABASE.".visa_services")->get();
        $viewData['services'] = $services;

        $tags = DB::table(MAIN_DATABASE.".tags")->get();
        $viewData['tags'] = $tags;

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $languages = DB::table(MAIN_DATABASE.".languages")->get();
        $roles = DB::table(MAIN_DATABASE.".roles")->get();
        $viewData['languages'] = $languages;
        $viewData['countries'] = $countries;

        $timestamp = time();
        $viewData['timestamp'] = $timestamp;
        $viewData['activeTab'] = "webinar";
        return view(roleFolder().'.webinar.add',$viewData);
    }


    public function save(Request $request){
        
        $field_validate = array('title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'level'=>'required',
            'language_id'=>'required',
            'webinar_date'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'total_seats'=>'required|numeric');
        if($request->input("paid_event")){
            $field_validate['event_cost'] = "required";
            $field_validate['price_group'] = "required";
        }
        if($request->input("offline_event")){
            $field_validate['address'] = "required";
            $field_validate['country_id'] = "required";
            $field_validate['state_id'] = "required";
            $field_validate['city_id'] = "required";
        }else{
            $field_validate['online_event_link'] = "required";
        }
        $validator = Validator::make($request->all(),$field_validate);

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
        $object->added_by = \Auth::user()->unique_id;
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
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('webinar');
        $response['message'] = "Webinar added successfully";
        return response()->json($response);
    }
 
    public function edit($unique_id,Request $request){
        $viewData['pageTitle'] = "Edit Webinar";
        $services = DB::table(MAIN_DATABASE.".visa_services")->get();
        $viewData['services'] = $services;

        $tags = DB::table(MAIN_DATABASE.".tags")->get();
        $viewData['tags'] = $tags;

        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $languages = DB::table(MAIN_DATABASE.".languages")->get();

        $viewData['languages'] = $languages;
        $viewData['countries'] = $countries;
        $record = Webinar::with(['Category','WebinarTags','WebinarTopics'])
                            ->where("unique_id",$unique_id)
                            ->first();
        $states = DB::table(MAIN_DATABASE.".states")->where('country_id',$record->country_id)->get();
        $cities = DB::table(MAIN_DATABASE.".cities")->where('state_id',$record->state_id)->get();
        $viewData['states'] = $states;
        $viewData['cities'] = $cities;
        $viewData['record'] = $record;
        $timestamp = time();
        $viewData['timestamp'] = $timestamp;
        $viewData['activeTab'] = "webinar";
        return view(roleFolder().'.webinar.edit',$viewData);
    }


    public function update($unique_id,Request $request){
        
        $field_validate = array('title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'level'=>'required',
            'language_id'=>'required',
            'webinar_date'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'total_seats'=>'required|numeric');
        if($request->input("paid_event")){
            $field_validate['event_cost'] = "required";
            $field_validate['price_group'] = "required";
        }
        if($request->input("offline_event")){
            $field_validate['address'] = "required";
            $field_validate['country_id'] = "required";
            $field_validate['state_id'] = "required";
            $field_validate['city_id'] = "required";
        }else{
            $field_validate['online_event_link'] = "required";
        }
        $validator = Validator::make($request->all(),$field_validate);


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

        $check_name_count = Webinar::where("title",$request->input('title'))
                                    ->where("unique_id",$unique_id)
                                    ->count();
        $slug = str_slug($request->input("title"));
        if($check_name_count > 0){
            $slug = $slug."-".($check_name_count+1);
        }
        $object = Webinar::where("unique_id",$unique_id)->first();
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
                    }else{
                        $images = implode(",",$filename);
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
        // pre($result);
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('webinar');
        $response['message'] = "Webinar updated successfully";
        return response()->json($response);
    }
    public function deleteImage($id,Request $request){
       
        $image = $request->input("image");
        $record = Webinar::where("unique_id",$id)->first();
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
        return redirect()->back()->with("success","Image has been deleted!");
        
    }
    public function deleteSingle($id){
       
        $record = Webinar::where("unique_id",$id)
                        ->first();
        Webinar::deleteRecord($record->id);
       
        return redirect()->back()->with("success","Webinar has been deleted!");
    }
}
