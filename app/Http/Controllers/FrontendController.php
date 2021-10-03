<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;
use Validator;
use DB;
use Razorpay\Api\Api;
use Image;
use View;

use App\Models\User;


class FrontendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('front', ['except' => ['signIn','invalid','login','autoLogin']]);
        \Config::set('database.connections.mysql.database', env("DB_DATABASE"));
       
    }

    public function index(){
        
        $now = \Carbon\Carbon::now();
        $viewData['pageTitle'] = "Home";
        $viewData['bodyClass'] = 'home';
        $viewData['headerClass'] = 'header_area_three';
        $viewData['events'] = Events::orderBy("id","desc")
                            ->whereHas("EventAuthors")
                            ->whereHas("Category")
                            ->where('status','publish')
                            ->where(DB::raw("(STR_TO_DATE(event_date,'%d-%m-%Y'))"), ">=",$now)
                            ->limit(3)
                            ->get();
        $viewData['popular_artciles'] = GeneralNotes::where("show_on_home","1")
                                    ->limit(3)
                                    ->where("status",'publish')
                                    ->orderBy("id","desc")
                                    ->get();
        $viewData['categories'] = GeneralCategory::withCount('Articles')
                                ->orderBy('name','asc')
                                ->whereHas("Articles")
                                ->where("is_popular",'1')
                                ->limit(5)
                                ->get();

        return view('front.home',$viewData);
    }
    public function aboutUs(){
        $viewData['pageTitle'] = "About Us";
        $viewData['bodyClass'] = 'aboutus';
        return view('front.aboutus',$viewData);
    }
    public function services(){
        $viewData['pageTitle'] = "Services";
        $viewData['bodyClass'] = 'ourservices';
        $services = Services::with("addedBy")
                    ->where("status",'publish')
                    ->paginate();
        $viewData['services'] = $services;
        return view('front.services.services',$viewData);
    }
    public function serviceDetail($author,$slug){

        $professional = ProfessionalPanel::where("subdomain",$author)->first();
        $viewData['subdomain'] = $author;
        $apiData = array();
        $apiData['search_by'] = "slug";
        $apiData['value'] = $slug;
        $service = serviceDetail($apiData,$professional->user_id);

        $apiData = array();
        $apiData['search_by'] = "similar";
        $apiData['value'] = $service->id;
        $similar_services = serviceDetail($apiData,$professional->user_id);

        // $service = Services::with("addedBy")->where("slug",$slug)->first();
        $viewData['pageTitle'] = $service->title;
        $viewData['bodyClass'] = 'services';
        $viewData['service'] = $service;
        $allowBooking = true;
        \Session::put("service_id",$service->id);
        if(Auth::check()){
            $is_booked = isServiceBooked($service->id,\Auth::user()->id,$professional->user_id);
            
            if($is_booked > 0){
                $allowBooking = false;
            }
        }
        $viewData['similar_services'] = $similar_services;
                            // Services::where("added_by",$service->added_by)
                            // ->limit(10)
                            // ->orderBy("id","desc")
                            // ->get();
        $viewData['allowBooking'] = $allowBooking;
        
        return view('front.services.service-detail',$viewData);
    }
    public function serviceSummary(Request $request){
        if($request->input("service")){
            $current_url= url()->full();
            
            if(Auth::user()->profile_status != 1){
                \Session::put("redirect_url",$current_url);
                return Redirect::to(baseUrl('complete-profile?redirect_back'));
            }
            $slug = $request->input("service");
            $subdomain = $request->input("author");
            $professional = ProfessionalPanel::where("subdomain",$subdomain)->first();

            $apiData['search_by'] = "slug";
            $apiData['value'] = $slug;

            $service = serviceDetail($apiData,$professional->user_id);
            // $curl_response = professionalApi("service",$professional->user_id,$apiData);
            // if($curl_response->status != 'success'){
            //     $viewData['api_error'] = $curl_response->message;
            //     $service = array();
            // }else{
            //     $data = $curl_response->data;
            //     $service = $data;
            // }
            // $serv = Services::with("addedBy")->where("slug",$slug)->first();
            \Session::put("service_id",$service->id);
            \Session::put("subdomain",$subdomain);
        }
        if(!Auth::check()){
            // \Session::put("redirect_back",\URL::current());
            return redirect('/login?redirect_back='.\URL::current());
        }

        $service_id = \Session::get("service_id");
        // $service = Services::find($service_id);
        $viewData['service'] = $service;
        $allowBooking = true;
        if(Auth::check()){
            $is_booked = isServiceBooked($service_id,\Auth::user()->id,$professional->user_id);
            if($is_booked > 0){
                $allowBooking = false;
            }
        }
        $viewData['allowBooking'] =  $allowBooking;
        return view('front.services.service-summary',$viewData);
    }
    public function payForService(Request $request){
        $service_id = \Session::get("service_id");
        $subdomain = \Session::get("subdomain");
        $professional = ProfessionalPanel::where("subdomain",$subdomain)->first();
        if(!Auth::check()){
            return redirect('/register');
        }else{
            $is_booked = isServiceBooked($service_id,\Auth::user()->id,$professional->user_id);
            if($is_booked > 0){
                \Session::forget("service_id");
                return redirect('/');
            }
        }
        if(Auth::user()->role != 'user'){
            return redirect("/");
        }
        
        
        $apiData['search_by'] = "id";
        $apiData['value'] = $service_id;

        $service = serviceDetail($apiData,$professional->user_id);
        // $service = Services::where("id",$service_id)->first();
        if(empty($service)){
            return redirect('/')->with("error","No such service exists");
        }
        
        \Session::put("service_id",$service->id);
        $viewData['pageTitle'] = "Pay Now";
        $viewData['bodyClass'] = 'paynow';
        $viewData['pay_amount'] = $service->price;
        $viewData['service'] = $service;
        return view('front.services.pay-now',$viewData);
    }
    public function contactUs(){
        $viewData['pageTitle'] = "Contact Us";
        $viewData['bodyClass'] = 'contactus';
        return view('front.contactus',$viewData);
    }

    public function articles(){
        $viewData['pageTitle'] = "Article Categories";
        $viewData['bodyClass'] = 'articles';
        $viewData['categories'] = GeneralCategory::withCount('Articles')
                                ->orderBy('name','asc')
                                ->whereHas("Articles")
                                ->where("is_popular","!=",1)
                                ->get();
        
        $viewData['popular_categories'] = GeneralCategory::withCount('Articles')
                                ->orderBy('name','asc')
                                ->whereHas("Articles")
                                ->where("is_popular",1)
                                ->get();
        return view('front.articles.categories',$viewData);
    }

    public function categoryArticles($slug){
        
        if(isset($_GET['view']) && $_GET['view'] != ''){
            \Session::put('display_view',$_GET['view']);
        }
        if(\Session::get('display_view')){
            $viewData['display_view'] = \Session::get('display_view');
        }else{
            $viewData['display_view'] = 'grid_view';
        }
        $category = array();
        if($slug == 'all'){
            $viewData['pageTitle'] = "All Articles";
        }else{
            $category = GeneralCategory::where("slug",$slug)->first();
            $viewData['pageTitle'] = ucfirst($category->name)." Articles";
        }
        $viewData['bodyClass'] = 'events';
        $viewData['category'] = $category;
        $viewData['article_by'] = "category";
        $viewData['slug'] = $slug;
        // $viewData['articles'] = GeneralNotes::with("GeneralCategory")
        //                     ->orderBy("title",'asc')
        //                     ->whereHas("GeneralCategory",function($query) use($category){
        //                         if(!empty($category)){
        //                             $query->where("category_id",$category->id);
        //                         }
        //                     })
        //                     ->where('status','publish')
        //                     ->paginate();
        $viewData['categories'] = GeneralCategory::orderBy('name','asc')->get();
        return view('front.articles.articles',$viewData);
    }
    public function articlesList(Request $request){
        $sort_by = $request->input("sort_by");
        $article_by = $request->input("article_by");
        $slug = $request->input("slug");
        $column = "title";
        $order = "asc";
        if($sort_by != ''){
            if($sort_by == 'date_desc'){
                $column = "created_at";    
                $order = "desc";
            }
            if($sort_by == 'date_asc'){
                $column = "created_at";    
                $order = "asc";
            }
            if($sort_by == 'title_asc'){
                $column = "title";    
                $order = "asc";   
            }
            if($sort_by == 'title_desc'){
                $column = "title";    
                $order = "desc";  
            }
        }
        if($article_by == 'category'){
            $category = array();
            if($slug != 'all'){
                $category = GeneralCategory::where("slug",$slug)->first();    
            }
            
            $records = GeneralNotes::with("GeneralCategory")
                    ->whereHas("GeneralCategory",function($query) use($category){
                        if(!empty($category)){
                            $query->where("category_id",$category->id);
                        }
                    })
                    ->where('status','publish')
                    ->orderBy($column,$order)
                    ->paginate(3);
        }else{
            $tag = GeneralTags::where("slug",$slug)->first();
            $records = GeneralNotes::with("GeneralTags")
                            ->whereHas("GeneralTags",function($query) use($tag){
                                $query->where("tag_id",$tag->id);
                            })
                            ->where('status','publish')
                            ->orderBy($column,$order)
                            ->paginate(3);
        }
        
        $viewData['articles'] = $records;
        $viewData['current_page'] = (string) $records->currentPage();
        $viewData['last_page'] = (string) $records->lastPage();
        $viewData['total_records'] = (string) $records->total();
        $view = View::make('front.articles.articles-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['paginate'] = (string) $records->links();
        $response['page_info'] = paginateInfo($records);
       
        return response()->json($response);
    }
    
    public function tagArticles($slug){
        $tag = GeneralTags::where("slug",$slug)->first();
        if(isset($_GET['view']) && $_GET['view'] != ''){
            \Session::put('display_view',$_GET['view']);
        }
        if(\Session::get('display_view')){
            $viewData['display_view'] = \Session::get('display_view');
        }else{
            $viewData['display_view'] = 'grid_view';
        }
        $viewData['pageTitle'] = ucfirst($tag->name)." Articles";
        $viewData['bodyClass'] = 'events';
        $viewData['category'] = $tag;
        $viewData['article_by'] = "tag";
        $viewData['slug'] = $slug;
        $viewData['articles'] = GeneralNotes::with("GeneralTags")
                            ->orderBy("title",'asc')
                            ->whereHas("GeneralTags",function($query) use($tag){
                                $query->where("tag_id",$tag->id);
                            })
                            ->where('status','publish')
                            ->paginate(3);
        $viewData['categories'] = GeneralCategory::orderBy('name','asc')->get();
        return view('front.articles.articles',$viewData);
    }

    public function articleDetail($slug){
        $notes = GeneralNotes::with('ExtraBlocks')
                            ->with('GeneralDocuments')
                            ->with('RightNotes')
                            ->where("slug",$slug)
                            ->first();
        $similar_articles = GeneralNotes::with('ExtraBlocks')
                            ->with('GeneralDocuments')
                            ->with('RightNotes')
                            ->where("added_by",$notes->added_by)
                            ->limit("5")
                            ->orderBy("id","desc")
                            ->where("status",'publish')
                            ->where("id","<>",$notes->id)
                            ->get();
     
        $viewData['pageTitle'] = $notes->title;
        $viewData['notes'] = $notes;
        $viewData['similar_articles'] = $similar_articles;
        $viewData['bodyClass'] = 'article-detail';
        return view('front.articles.article-detail',$viewData);
    }

    public function events(){
        $viewData['pageTitle'] = "Event Categories";
        $viewData['bodyClass'] = 'events';
        $viewData['categories'] = GeneralCategory::withCount('Events')
                                ->orderBy('name','asc')
                                ->whereHas("Events")
                                ->get();
        
       
        return view('front.events.categories',$viewData);
    }

    public function categoryEvents($slug){
        
        if(isset($_GET['view']) && $_GET['view'] != ''){
            \Session::put('display_view',$_GET['view']);
        }
        if(\Session::get('display_view')){
            $viewData['display_view'] = \Session::get('display_view');
        }else{
            $viewData['display_view'] = 'grid_view';
        }
        $category = array();
        if($slug == 'all'){
            $viewData['pageTitle'] = "All Events";
        }else{
            $category = GeneralCategory::where("slug",$slug)->first();
            $viewData['pageTitle'] = ucfirst($category->name)." Events";
        }
        $viewData['category'] = $category;
        $viewData['bodyClass'] = 'events';
        $viewData['event_by'] = "category";
        $viewData['slug'] = $slug;
        // $viewData['events'] = Events::orderBy("event_date",'desc')
        //                     // ->where("category_id",$category->id)
        //                     ->where(function($query) use($category){
        //                         if(count($category) > 0){
        //                             $query->where("category_id",$category->id);
        //                         }
        //                     })
        //                     ->where("event_date",">=",date('d-m-Y'))
        //                     ->whereHas("EventAuthors")
        //                     ->whereHas("Category")
        //                     ->where('status','publish')
        //                     ->paginate();
        $viewData['categories'] = GeneralCategory::orderBy('name','asc')->get();
        $viewData['tags'] = EventTags::orderBy('name','asc')->get();
        // $viewData['popular_events'] = Events::where("is_popular","1")
        //                             // ->where("category_id",$category->id)
        //                             ->where(function($query) use($category){
        //                                 if(count($category) > 0){
        //                                     $query->where("category_id",$category->id);
        //                                 }
        //                             })
        //                             ->limit(3)
        //                             ->get();
        $viewData['languages'] = Language::get();
        return view('front.events.events',$viewData);
    }
    public function eventsList(Request $request){
        $now = \Carbon\Carbon::now();
        $sort_by = $request->input("sort_by");
        $event_by = $request->input("event_by");
        $search = $request->all();
        $slug = $request->input("slug");
        $column = "title";
        $order = "asc";
        if($sort_by != ''){
            if($sort_by == 'date_desc'){
                $column = "created_at";    
                $order = "desc";
            }
            if($sort_by == 'date_asc'){
                $column = "created_at";    
                $order = "asc";
            }
            if($sort_by == 'title_asc'){
                $column = "title";    
                $order = "asc";   
            }
            if($sort_by == 'title_desc'){
                $column = "title";    
                $order = "desc";  
            }
        }
        if($event_by == 'category'){
            if($slug != 'all'){
                $category = GeneralCategory::where("slug",$slug)->first();    
            }else{
                $category = array();
            }
            
            $records = Events::where(DB::raw("(STR_TO_DATE(event_date,'%d-%m-%Y'))"), ">=",$now)
                            ->where(function($query) use($category){
                                if(!empty($category)){
                                    $query->where("category_id",$category->id);
                                }
                            })
                            ->whereHas("EventAuthors")
                            ->whereHas("Category")
                            ->where('status','publish')
                            ->where(function($query) use($search){
                                if(isset($search['language'])){
                                    $query->whereIn("language",$search['language']);
                                }
                                if(isset($search['tag'])){
                                    $tag_id = $search['tag'];
                                    $query->whereHas("EventTags",function($q) use($tag_id){
                                        $q->whereIn("tag_id",$tag_id);
                                    });
                                }
                                if(isset($search['event_type'])){
                                    $query->where("is_offline",$search['event_type']);
                                }
                                if(isset($search['level'])){
                                    $query->where("level",$search['level']);
                                }
                                if(isset($search['category'])){
                                    $category = $search['category'];
                                    $query->whereIn("category_id",$category);
                                }
                            })
                            ->paginate(3);
        }else{
            $tag = EventTags::where("slug",$slug)->first();
            $records = Events::orderBy("event_date",'desc')
                            ->where(DB::raw("(STR_TO_DATE(event_date,'%d-%m-%Y'))"), ">=",$now)
                            ->whereHas("EventAuthors")
                            ->whereHas("EventTags",function($query) use($tag){
                                $query->where("tag_id",$tag->id);
                            })
                            ->where('status','publish')
                            ->where(function($query) use($search){
                                if(isset($search['language'])){
                                    $query->whereIn("language",$search['language']);
                                }
                                if(isset($search['event_type'])){
                                    $query->where("is_offline",$search['event_type']);
                                }
                                if(isset($search['level'])){
                                    $query->where("level",$search['level']);
                                }
                                if(isset($search['category'])){
                                    $category = $search['category'];
                                    $query->whereIn("category_id",$category);
                                }

                            })
                            ->paginate(3);
        }
        
        $viewData['events'] = $records;
        $viewData['current_page'] = (string) $records->currentPage();
        $viewData['last_page'] = (string) $records->lastPage();
        $viewData['total_records'] = (string) $records->total();
        $view = View::make('front.events.events-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['paginate'] = (string) $records->links();
        $response['page_info'] = paginateInfo($records);
       
        return response()->json($response);
    }
    

    public function tagEvents($slug){
        $tag = EventTags::where("slug",$slug)->first();
        if(isset($_GET['view']) && $_GET['view'] != ''){
            \Session::put('display_view',$_GET['view']);
        }
        if(\Session::get('display_view')){
            $viewData['display_view'] = \Session::get('display_view');
        }else{
            $viewData['display_view'] = 'grid_view';
        }
        $viewData['pageTitle'] = ucfirst($tag->name)." Events";
        $viewData['bodyClass'] = 'events';
        $viewData['category'] = $tag;
        $viewData['event_by'] = "tag";
        $viewData['slug'] = $slug;
        // $viewData['events'] = Events::orderBy("event_date",'desc')
        //                     ->where("event_date",">=",date('d-m-Y'))
        //                     ->whereHas("EventAuthors")
        //                     ->whereHas("EventTags",function($query) use($tag){
        //                         $query->where("tag_id",$tag->id);
        //                     })
        //                     ->where('status','publish')
        //                     ->paginate();
        // $viewData['popular_events'] = Events::where("is_popular","1")
        //             ->whereHas("EventTags",function($query) use($tag){
        //                 $query->where("tag_id",$tag->id);
        //             })
        //             ->limit(3)->get();
        $viewData['languages'] = Language::get();
        $viewData['categories'] = GeneralCategory::orderBy('name','asc')->get();
        $viewData['tags'] = EventTags::orderBy('name','asc')->get();
        return view('front.events.events',$viewData);
    }

    public function eventDetail($slug){
        $event = Events::where("slug",$slug)->first();
        $viewData['pageTitle'] = $event->title;
        $viewData['bodyClass'] = 'events';
        $viewData['event'] = $event;
        $allowBooking = true;
        \Session::put("event_id",$event->id);
        if(Auth::check()){
            $is_booked = isEventBooked($event->id,\Auth::user()->id,$event->added_by);
            
            if($is_booked > 0){
                $allowBooking = false;
            }
        }
        $viewData['similar_events'] = Events::where("category_id",$event->category_id)
                            ->limit(5)
                            ->orderBy("id","desc")
                            ->where("id","<>",$event->id)
                            ->where("status",'publish')
                            ->get();
        $viewData['allowBooking'] = $allowBooking;
        $viewData['categories'] = GeneralCategory::orderBy('name','asc')->get();

        $viewData['event_users'] = EventBooked::where("event_id",$event->id)
                            ->whereHas("UserInfo")
                            ->orderBy("id","desc")
                            ->get();
        return view('front.events.event-detail',$viewData);
    }
    
    public function payNow(Request $request){
        $event_id = \Session::get("event_id");
        $event = Events::find($event_id);
        if(!Auth::check()){
            return redirect('/register');
        }else{
            $is_booked = isEventBooked($event_id,\Auth::user()->id,$event->added_by);
            if($is_booked > 0){
                \Session::forget("event_id");
                return redirect('/');
            }
        }
        if(Auth::user()->role != 'user'){
            return redirect("/");
        }
        
        $event = Events::where("id",$event_id)->first();
        if(empty($event)){
            return redirect('/')->with("error","No such event exists");
        }
        
        \Session::put("event_id",$event->id);
        $viewData['pageTitle'] = "Pay Now";
        $viewData['bodyClass'] = 'paynow';
        $viewData['pay_amount'] = $event->price;
        $viewData['event'] = $event;
        return view('front.events.pay-now',$viewData);
    }
    public function eventSummary(Request $request){
        if(!Auth::check()){
            // \Session::put("redirect_back",\URL::current());
            return redirect('/login?redirect_back='.\URL::current());
        }
        if($request->input("event_id")){
            $event_id = $request->input("event_id");
            \Session::put("event_id",$event_id);
        }else{
            $event_id = \Session::get("event_id");
        }
        $event = Events::find($event_id);
        $viewData['event'] = $event;
        $allowBooking = true;
        if(Auth::check()){
            $is_booked = isEventBooked($event_id,\Auth::user()->id,$event->added_by);
            if($is_booked > 0){
                $allowBooking = false;
            }
        }
        $viewData['allowBooking'] =  $allowBooking;
        return view('front.events.event-summary',$viewData);
    }
    public function bookSeat(Request $request){
        if(!Auth::check()){
            return redirect('/register');
        }
        $event_id = \Session::get("event_id");
        $event = Events::where("id",$event_id)->first();
        
        $object = new EventBooked();
        $object->user_id = \Auth::user()->id;
        $object->event_id = $event_id;
        $object->author_id = $event->added_by;
        $object->payment_status = 'success';
        $object->amount_paid = $event->price;
        $object->event = json_encode($event);
        $object->save();

        return redirect(baseUrl('/'))->with("success","Event booked successfully");
    }   

    public function submitPayNow(Request $request)
    {
        try {
            $api = new Api(config('custom.razor_key'), config('custom.razor_secret'));
            $order_id = "order_".mt_rand(1,9999);
            $amount = $request->input("amount");
            $order  = $api->order->create([
              'receipt'         => $order_id,
              'amount'          => $amount, // amount in the smallest currency unit
              'currency'        => 'INR',// <a href="https://razorpay.freshdesk.com/support/solutions/articles/11000065530-what-currencies-does-razorpay-support" target="_blank">See the list of supported currencies</a>.)
              'payment_capture' =>  '0'
            ]);
            if(isset($order->id)){
                $response['status'] = true;
                $response['order_id'] = $order->id;
            }else{
                $response['status'] = false;
                $response['message'] = 'Order id not generated';
            }
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function paymentSuccess(Request $request){

        $razorpay_payment_id = $request->input("razorpay_payment_id");
        $razorpay_order_id = $request->input("razorpay_order_id");
        $razorpay_signature = $request->input("razorpay_signature");
        $event_id = \Session::get("event_id");
        $api = new Api(config('custom.razor_key'), config('custom.razor_secret'));
        $payment = $api->payment->fetch($razorpay_payment_id);
        $event = Events::where("id",$event_id)->first()->toArray();
        try {
            $result = $api->payment->fetch($razorpay_payment_id)
            ->capture(array('amount'=>$payment['amount'])); 
            $result = $result->toArray();

            $object = new EventBooked();
            $object->user_id = \Auth::user()->id;
            $object->event_id = $event_id;
            $object->razorpay_payment_id = $razorpay_payment_id;
            $object->razorpay_order_id = $razorpay_order_id;
            $object->razorpay_signature = $razorpay_signature;
            $object->payment_method = $payment->method;
            $object->payment_status = 'success';
            $object->amount_paid = $payment->amount / 100;
            $object->response = json_encode($result);
            $object->event = json_encode($event);
            $object->save();
            $amount_paid = $payment->amount / 100;

            \Session::forget("event_id");
     
            $response['status'] = true;
            $response['message'] = 'Event booked successfully';

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            
        }
        
       return response()->json($response);
    }

    public function servicePaymentSuccess(Request $request){

        $razorpay_payment_id = $request->input("razorpay_payment_id");
        $razorpay_order_id = $request->input("razorpay_order_id");
        $razorpay_signature = $request->input("razorpay_signature");
        $service_id = \Session::get("service_id");
        $subdomain = \Session::get("subdomain");
        $api = new Api(config('custom.razor_key'), config('custom.razor_secret'));
        $payment = $api->payment->fetch($razorpay_payment_id);

        $professional = ProfessionalPanel::where("subdomain",$subdomain)->first();
        $apiData['search_by'] = "id";
        $apiData['value'] = $service_id;

        $service = serviceDetail($apiData,$professional->user_id);

        // $service = Services::where("id",$service_id)->first()->toArray();
        try {
            $result = $api->payment->fetch($razorpay_payment_id)
            ->capture(array('amount'=>$payment['amount'])); 
            $result = $result->toArray();

            $object = new ServiceBooked();
            $object->user_id = \Auth::user()->id;
            $object->service_id = $service_id;
            $object->author_id = $professional->user_id;
            $object->razorpay_payment_id = $razorpay_payment_id;
            $object->razorpay_order_id = $razorpay_order_id;
            $object->razorpay_signature = $razorpay_signature;
            $object->payment_method = $payment->method;
            $object->payment_status = 'success';
            $object->amount_paid = $payment->amount / 100;
            $object->response = json_encode($result);
            $object->save();
            $amount_paid = $payment->amount / 100;

            \Session::forget("service_id");
            
            $check_exists = UserWithProfessional::where("user_id",\Auth::user()->id)
                            ->where("professional_id",$professional->user_id)
                            ->first();
            if(!empty($check_exists)){
                $userwithprof = UserWithProfessional::find($check_exists->id);
            }else{
                $userwithprof = new UserWithProfessional();
            }
            $userwithprof->user_id = \Auth::user()->id;
            $userwithprof->professional_id = $professional->user_id;
            $userwithprof->user_type = 'client';
            $userwithprof->save();                
           

            $check_service = UserServices::where("user_id",\Auth::user()->id)
                                ->where("professional_id",$professional->user_id)
                                ->where("service_id",$service_id)
                                ->first();
            if(!empty($check_service)){
                $userservice = UserServices::find($check_service->id);
            }else{
                $userservice = new UserServices();   
                $userservice->user_id = \Auth::user()->id;
                $userservice->professional_id = $professional->user_id;
                $userservice->service_id = $service_id; 
            }
            $userservice->status = 1;
            $userservice->approved_at = date("Y-m-d H:i:s");
            $userservice->save();

            $response['status'] = true;
            $response['message'] = 'Service purchase successfully';

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            
        }
        
       return response()->json($response);
    }

    public function paymentFailed(Request $request){

        $amount_paid = $request->input("amount_paid");
        $payment_method = $request->input("payment_method");
        $description = $request->input("description");

       
        try {
          
            // $object = new EventBooked();
            // $object->user_id = \Auth::user()->id;
            // $object->payment_method = $payment_method;
            // $object->description = $description;
            // $object->payment_status = 'success';
            // $object->amount_paid = $amount_paid;
            // $object->response = json_encode($result);
            // $object->save();

            $response['status'] = false;
            $response['message'] = 'Payment failed try again later';

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            
        }
        
       return response()->json($response);
    }

    

    public function signUp(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
            'country_code' => 'required',
            'phone_no' => 'required',
            'verify_by'=>'required',
            'verification_code'=>'required',
        ]);

        
        session(['redirect_back' => $request->input('redirect_back')]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        

        $phone = $request->input("country_code").$request->input("phone_no");
        
        if($request->input("verify_by") == 'sms'){
            $res = verifyCode(\Session::get("service_code"),$request->input('verification_code'),$phone);
            // pre(\Session::get("service_code")." ".$request->input('verification_code')." ".$phone);
            // pre($res);
            // exit;
            if($res['status'] == false){
                return redirect()->back()
                        ->with("verification_code","OTP Verification code entered is invalid")
                        ->withInput();
            }
        }else{
            $date = date("Y-m-d H:i:s");
            $match_code = VerificationCode::where("verify_by","email")
                        ->where("match_string",$request->input("email"))
                        ->where("verify_code",$request->input("verification_code"))
                        ->whereDate("expiry_time","<",$date)
                        ->count();
            // if($request->input("verification_code") != \Session::get("verify_code")){
           if($match_code <= 0){
                return redirect()->back()
                        ->with("verification_code","Verification code entered is invalid")
                        ->withInput();
            }
            VerificationCode::where("match_string",$request->input("email"))->delete();
        }
        $object = new User();
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->password = bcrypt($request->input("password"));
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->role = $request->input("user_type");
        $object->is_active = 1;
        $object->is_approved = 1;
        
        $object->save();
        $user_id = $object->id;
        Auth::loginUsingId($user_id);
        
        if($request->input("user_type") == 'user'){
            // // Auth::loginUsingId($user_id);
            // $apiData = $request->input();
            // $apiData['user_id'] = $user_id;
            // $curl_response = userApi('create-user',$apiData);
            
            // if($curl_response->status == 'success'){
            //     $upData['user_db_id'] = $curl_response->user_id;
            //     User::where("id",$user_id)->update($upData);                
            //     Auth::loginUsingId($user_id);
            //     $redirect_url = userPanelUrl()."/loggedin?uid=".base64_encode($curl_response->user_id);
            //     \Session::forget("verify_code");
            //     return redirect($redirect_url);    
            // }else{
            //     if(isset($curl_response->validation_error) && $curl_response->validation_error == 'email_exists'){
            //         User::where("id",$curl_response->user_id)->delete();
            //         return redirect()->back()->withInput()->with("email_taken",$curl_response->message);
            //     }
            // }
        }else{
            $object = new ProfessionalDetails();
            $object->user_id = $user_id;
            $object->save();
        }
        \Session::forget("verify_code");
        // return redirect('/home');    
        // return redirect('/login')->with("success_message","Your account has been register. Our team will contact you soon");   
        if(!empty($request->input('redirect_back'))){
            return redirect($request->input('redirect_back'));    
        }else{
            return redirect('/home');    
        }
    }

    public function author($slug){
        $author_explode = explode("-",$slug);
        $id = end($author_explode);
        $author = User::find($id);
        $professionl = ProfessionalPanel::where("user_id",$id)->first();
        $viewData['subdomain'] = $professionl->subdomain;
        // $services = Services::where("author_id",$author->id)->get();
        $curl_response = professionalApi("get-services",$id);
        if($curl_response->status != 'success'){
            $viewData['api_error'] = $curl_response->message;
            $services = array();
        }else{
            $data = $curl_response->data;
            $services = $data;
        }
        $viewData['pageTitle'] = "Author ".$author->first_name." ".$author->last_name;
        $viewData['bodyClass'] = 'author_page';
        $viewData['headerClass'] = 'header_area_three';
        $viewData['author'] = $author;
        // $service_categories = Services::where("author_id",$author->id)
        //             ->groupBy("category_id")
        //             ->pluck('category_id');
        $service_list = array();
        if(count($services) > 0){
            // $service_categories = $service_categories->toArray();
            $service_categories = array();
            foreach($services as $service){
                if(!in_array($service->category_id,$service_categories)){
                    $service_categories[] = $service->category_id;
                }
            }
            $categories = ServiceCategory::whereIn("id",$service_categories)->get();

            foreach($categories as $category){
                
                $apiData['category_id'] = $category->id;
                $curl_response = professionalApi("get-services",$id,$apiData);
                if($curl_response->status != 'success'){
                    $viewData['api_error'] = $curl_response->message;
                    $services_data = array();
                }else{
                    $data = $curl_response->data;
                    $services_data = $data;
                }
                $temp = $category;
                // $temp->ServicesList = Services::where("author_id",$author->id)
                //     ->where("category_id",$category->id)
                //     ->get();
                $temp->ServicesList = $services_data;
                $service_list[] = $temp;
            }
        }
        $viewData['service_list'] = $service_list;
        // $service_categories = ServiceCategory::with('Services')
        // ->whereHas("Services",function($query) use($id){
        //     $query->where("author_id",$id);
        // })->get();
        return view('front.author',$viewData);
    }

    public function Image(){
        $viewData['pageTitle'] = 'Image';
        return view('front.image',$viewData);   
    }

    public function uploadImage(Request $request)
    {
        $image = base_path('assets/front/images/bg/video-bg.jpg');
        $img = Image::make($image);
        $croppath = public_path('uploads/demo/crop/video-bg.jpg');
        $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
        $img->save($croppath);
        return redirect('image')->with(['success' => "Image cropped successfully."]);
        // if ($file = $request->file('profile_image')){
            
        //     $fileName        = $file->getClientOriginalName();
        //     $extension       = $file->getClientOriginalExtension() ?: 'png';
        //     $newName        = mt_rand(1,99999)."-".$fileName;
        //     $source_url = $file->getPathName();
            
        //     $destinationPath = public_path('/uploads/demo/');
        //     if($file->move($destinationPath, $newName)){
        //         $img = Image::make(public_path('uploads/demo/'.$newName));
        //         $croppath = public_path('uploads/demo/crop/'.$newName);
         
        //         $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
        //         $img->save($croppath);
        //         $path = asset('public/uploads/demo/crop/'.$newName);
        //         return redirect('image')->with(['success' => "Image cropped successfully.", 'path' => $path]);
        //     }
        // }
    }

    public function serviceEnquiry($author,$service_id){
        try{
            // $service = Services::find($service_id);
            $professional = ProfessionalPanel::where("user_id",$author)->first();
            $apiData['search_by'] = "id";
            $apiData['value'] = $service_id;
            $service = serviceDetail($apiData,$professional->user_id);

            $viewData['service'] = $service;
            $view = View::make('front.modal.service-enquiry',$viewData);
            $contents = $view->render();
            $response['status'] = true;
            $response['contents'] = $contents;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function sendServiceEnquiry($id,Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'enquiry_title' => 'required',
                'enquiry_description' => 'required',
            ]);

            if ($validator->fails()) {
                $response['status'] = false;
                $error = $validator->errors()->toArray();
                $errMsg = '';
                foreach($error as $err){
                    $errMsg .= $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }
            $object = new ServiceEnquiry();
            $object->service_id = $id;
            $object->author_id = $request->input("author_id");
            $object->enquiry_title = $request->input("enquiry_title");
            $object->enquiry_description = $request->input("enquiry_description");
            $object->added_by = \Auth::user()->id;
            $object->save();

            $check_exists = UserWithProfessional::where("user_id",\Auth::user()->id)
                            ->where("professional_id",$request->input("author_id"))
                            ->first();
            if(empty($check_exists)){
                $userwithprof = new UserWithProfessional();
                $userwithprof->user_id = \Auth::user()->id;
                $userwithprof->professional_id = $request->input("author_id");
                $userwithprof->user_type = 'lead';
                $userwithprof->save();                
            }            
            $response['status'] = true;
            $response['message'] = 'Service enquiry send successfully';
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function followAuthor(Request $request){
        $author_id = $request->input("author_id");
        AuthorFollowers::where("user_id",\Auth::user()->id)->where("author_id",$author_id)->delete();
        $object = new AuthorFollowers();
        $object->user_id = \Auth::user()->id;
        $object->author_id = $author_id;
        $object->save();
        $response['status'] = true;
        $response['message'] = 'You followed the author';
        return response()->json($response);
    }
    public function unfollowAuthor(Request $request){
        $author_id = $request->input("author_id");
        AuthorFollowers::where("user_id",\Auth::user()->id)->where("author_id",$author_id)->delete();
        $response['status'] = true;
        $response['message'] = 'You unfollow the author';
        return response()->json($response);

    }

    public function authorEvents(Request $request)
    {
        $author_id = $request->input("author_id");
        $records = Events::orderBy('id','desc')
                    ->where("status",'publish')
                    ->where("added_by",$author_id)
                    ->paginate(4);

        $viewData['records'] = $records;
        $viewData['current_page'] = (string) $records->currentPage();
        $viewData['last_page'] = (string) $records->lastPage();
        $viewData['total_records'] = (string) $records->total();
        $view = View::make('front.author-events',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['paginate'] = (string) $records->links();
        $response['page_info'] = "Page ".$records->currentPage()." of ".$records->lastPage()." <small>(".$records->total()." records)</small>";
        return response()->json($response);
    }

    public function authorArticles(Request $request)
    {
        $author_id = $request->input("author_id");
        $records = GeneralNotes::orderBy('id','desc')
                    ->where("status",'publish')
                    ->where("added_by",$author_id)
                    ->paginate(4);

        $viewData['records'] = $records;
        $viewData['current_page'] = (string) $records->currentPage();
        $viewData['last_page'] = (string) $records->lastPage();
        $viewData['total_records'] = (string) $records->total();
        $view = View::make('front.author-articles',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['paginate'] = (string) $records->links();
        $response['page_info'] = "Page ".$records->currentPage()." of ".$records->lastPage()." <small>(".$records->total()." records)</small>";
        return response()->json($response);
    }

    public function bookmarkArticle(Request $request){
        try{
            $object = new UserArticlesBookmark();
            $object->user_id = \Auth::user()->id;
            $object->article_id = $request->input("article_id");
            $object->save();

            $response['status'] = true;
            $response['message'] = "Article bookmarked successfully";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function removeBookmarkArticle(Request $request){
        try{
            UserArticlesBookmark::where("article_id",$request->input("article_id"))
                                ->where("user_id",\Auth::user()->id)
                                ->delete();

            $response['status'] = true;
            $response['message'] = "Article removed from bookmark";
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function popularEvents(Request $request){
        try{
            if($request->input("category_id")){
                $category_id = $request->input("category_id");
            }else{
                $category_id = '';
            }
            $now = \Carbon\Carbon::now();
            
            $popular_events = Events::where("is_popular","1")
                                    ->where(function($query) use($category_id){
                                        if($category_id != ''){
                                            $query->where("category_id",$category_id);
                                        }
                                    })   
                                    ->where(DB::raw("(STR_TO_DATE(event_date,'%d-%m-%Y'))"), ">=",$now)
                                    ->paginate(3);  
            $viewData['popular_events']  = $popular_events;
            $view = View::make('front.events.popular-events',$viewData);
            $contents = $view->render();
            $response['status'] = true;
            $response['contents'] = $contents;
            $response['count'] = count($popular_events);
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
              
    }
    public function articleHelpful(Request $request){
        try{
            $article_id = $request->input("article_id");
            $status = $request->input("status");
            $is_exists = $request->input("is_exists");
            if($status == 'yes'){
                GeneralNotes::where('id', $article_id)
                ->update([
                  'like_count'=> DB::raw('like_count+1')
                ]);
                if($is_exists == 1){
                   GeneralNotes::where('id', $article_id)
                    ->update([
                      'dislike_count'=> DB::raw('dislike_count-1')
                    ]); 
                }
            }else{
                GeneralNotes::where('id', $article_id)
                ->update([
                  'dislike_count'=> DB::raw('dislike_count+1')
                ]);
                if($is_exists == 1){
                   GeneralNotes::where('id', $article_id)
                    ->update([
                      'like_count'=> DB::raw('like_count-1')
                    ]); 
                }
            }
            $response['status'] = true;
            $response['message'] = 'Your feedback added';

        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    
    public function register(Request $request){
        // if(\Session::get('login_to') != 'admin_panel'){
        //     return Redirect::to('/');
        // }
        if(Auth::check()){
            return Redirect::to(baseUrl('/'));
        }
        $viewData['pageTitle'] = 'Sign Up';
        $viewData['user_type'] = "user";
        return view('auth.signup',$viewData);   
    }
    public function userRegister(Request $request){
        // if(\Session::get('login_to') != 'admin_panel'){
        //     return Redirect::to('/');
        // }
        if(Auth::check()){
            return Redirect::to(baseUrl('/'));
        }
        $viewData['pageTitle'] = 'Sign Up as User';
        $viewData['user_type'] = "user";
        $viewData['countries'] = Countries::get();
        return view('auth.user-signup',$viewData);   
    }
    public function professionalRegister(Request $request){
        if(\Session::get('login_to') != 'admin_panel'){
            return Redirect::to('/');
        }
        if(Auth::check()){
            return Redirect::to(baseUrl('/'));
        }
        $viewData['pageTitle'] = 'Sign Up as Professional';
        $viewData['user_type'] = "professional";
        $viewData['countries'] = Countries::get();
        return view('auth.professional-signup',$viewData);   
    }

    public function invalid(){
        if(\Session::has('error_message')){
            $viewData['pageTitle'] = 'Invalid Access';
            return view('front.invalid-access',$viewData);      
        }else{
            return Redirect::to(baseUrl('/'));
        }
    }
   

    public function verifyPhone(Request $request){
        try{
            $country_code = $request->input("country_code");
            $phone_no = $request->input("phone_no");
            $twilio = new TwilioApi(env('TWILIO_SID'),env('TWILIO_TOKEN'));
            $response = $twilio->verifyPhone($phoneno);
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }    

    public function VisaTypes($slug){
        $record = VisaTypes::where("slug",$slug)->first();
        $contents = array();
        if($record->content_ids != ''){
            $content_ids = explode(",",$record->content_ids);
            $contents = Contents::whereIn("id",$content_ids)->get();
        }
        $viewData['contents'] = $contents;
        $additional_data = VisaTypeBlocks::where("visa_type_id",$record->id)
                            ->orderBy("sort_order","asc")
                            ->get();
        $viewData['pageTitle'] = $record->name;
        $viewData['bodyClass'] = 'visa_type';
        $viewData['visa_type'] = $record;
        $viewData['additional_data'] = $additional_data;
        return view('front.visa-types.visatype-detail',$viewData);
    }

    public function Contents($slug){
        $record = Contents::where("slug",$slug)->first();
        $viewData['content'] = $record;
        $additional_data = AdditionalContents::where("content_id",$record->id)
                            ->orderBy("sort_order","asc")
                            ->get();
        $viewData['pageTitle'] = $record->name;
        $viewData['additional_data'] = $additional_data;
        return view('front.visa-types.contents-detail',$viewData);
    }

    public function payForTimeline(Request $request){

        $timeline_id = $request->get("timeline_id");
        $subdomain = $request->get("subdomain");
        
        \Session::put("timeline_id",$timeline_id);
        \Session::put("subdomain",$subdomain);
        $professional = ProfessionalPanel::where("subdomain",$subdomain)->first();
        if(!Auth::check()){
            return redirect('/register');
        }
        // else{
        //     $is_booked = isServiceBooked($service_id,\Auth::user()->id,$professional->user_id);
        //     if($is_booked > 0){
        //         \Session::forget("service_id");
        //         return redirect('/');
        //     }
        // }
        // if(Auth::user()->role != 'user'){
        //     return redirect("/");
        // }
        
        
        $apiData['timeline_id'] = $timeline_id;
        $curl_response = professionalApi("timeline-detail",$professional->user_id,$apiData);
        
        $timeline_detail = array();
        if($curl_response->status != 'success'){
            $viewData['error'] = 'Invalid payment request';
        }else{
            $timeline_detail = $curl_response->data;
        }
        
        $viewData['timeline_detail'] = $timeline_detail;
        $viewData['pageTitle'] = "Pay Now";
        $viewData['bodyClass'] = 'paynow';
        $viewData['pay_amount'] = $timeline_detail->ask_for_payment;
        return view('user.timeline-pay-now',$viewData);
    }

    public function timelinePaymentSuccess(Request $request){
        try {
            $apiData = $request->all();
            $timeline_id = \Session::get("timeline_id");
            $subdomain = \Session::get("subdomain");
            $apiData['timeline_id'] = $timeline_id;
            $razorpay_payment_id = $request->input("razorpay_payment_id");
            $razorpay_order_id = $request->input("razorpay_order_id");
            $razorpay_signature = $request->input("razorpay_signature");

            $api = new Api(config('custom.razor_key'), config('custom.razor_secret'));
            $payment = $api->payment->fetch($razorpay_payment_id);
            
            $professional = ProfessionalPanel::where("subdomain",$subdomain)->first();
            
            // $service = Services::where("id",$service_id)->first()->toArray();
            $result = $api->payment->fetch($razorpay_payment_id)
            ->capture(array('amount'=>$payment['amount'])); 
            $result = $result->toArray();

            $apiData['result'] = $result;
            $apiData['payment'] = $payment;
            $apiData['user_id'] = \Auth::user()->id;
            $apiData['payment_amount'] = $payment->amount;
            $apiData['payment_method'] = $payment->method;
            $curl_response = professionalApi("send-timeline-payment",$professional->user_id,$apiData);
            
            if($curl_response->status != 'success'){
                $response['status'] = true;
            }else{
                $response['status'] = true;
                $response['message'] = 'Service purchase successfully';    
            }

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            
        }
        
       return response()->json($response);
    }

    public function checkEligibility($slug){
        $visa_type = VisaTypes::with('VisaDocuments')->where("slug",$slug)->first();
        $steps = EligibilitySteps::where("visa_type_id",$visa_type->id)->first();
        
        $eligibility_questions = array();
        if($steps->sequence != ''){
            $sequence = json_decode($steps->sequence,true);

            for($i=0;$i < count($sequence);$i++){
                for($j=0;$j < count($sequence[$i]);$j++){
                    $qids[] = $sequence[$i][$j];

                    $questions = EligibilityQuestions::with('LinkedQuestion')
                                    ->with('Options')
                                    ->where("id",$sequence[$i][$j])
                                    ->first();
                   

                    if(!empty($questions)){
                        $eligibility_questions[$i][] = $questions;
                    }
                }
            }
        }
        $viewData['eligibility_questions'] = $eligibility_questions;
        $viewData['pageTitle'] = $visa_type->title;
        $viewData['bodyClass'] = 'visa-detail';
        $viewData['visa_type'] = $visa_type;
        return view('front.check-visa-eligibility',$viewData);
    }   
    public function verifyEligibility($visa_type_id,Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone_no' => 'required',
                'questions' => 'required',
            ]);

            if ($validator->fails()) {
                $response['status'] = false;
                $error = $validator->errors()->toArray();
                $errMsg = '';
                foreach($error as $err){
                    $errMsg .= $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }
            $visa_type_id = base64_decode($visa_type_id);
            $object = new EligibilityCheck();
            $object->first_name = $request->input("first_name");
            $object->last_name = $request->input("last_name");
            $object->email = $request->input("email");
            $object->phone_no = $request->input("phone_no");
            $object->visa_type = $visa_type_id;
            $object->response = json_encode($request->input("questions"));
            $object->type = 'eligibility';
            $object->save();
            $questions = $request->input("questions");
            
            $eligibilitySteps = EligibilitySteps::where("visa_type_id",$visa_type_id)->first();
            $match_visa = array();
            if(!empty($eligibilitySteps)){
                $criteriaResponse = CriteriaResponse::where('eligibility_step_id',$eligibilitySteps->id)->get();
                if(!empty($criteriaResponse)){
                    foreach($criteriaResponse as $criteria){
                        $res = json_decode($criteria->response,true);
                        $visa_type_ids = json_decode($criteria->visa_type_id,true);
                        $answer_match = 0;
                        foreach($res as $k => $v){
                            if(is_array($v)){
                                if(isset($questions[$k]) && in_array($questions[$k],$v)){
                                    $answer_match++;
                                }
                            }else{
                                if(isset($questions[$k]) && $questions[$k] == $v){
                                    $answer_match++;   
                                }
                            }
                        }
                        // echo $answer_match." = ".count($questions)."\n\n";
                        if($answer_match == count($questions)){
                            for($v=0;$v < count($visa_type_ids);$v++){
                                if(!in_array($visa_type_ids[$v],$match_visa)){
                                    $match_visa[] = $visa_type_ids[$v];
                                }
                            }
                        }
                    }
                }
            }
            $response['status'] = true;

            if(count($match_visa) > 0){
                $response['match_visa'] = implode(",",$match_visa);
                $response['match_found'] = 'yes';
                $html = "<form id='response-form' method='post' formtarget='_blank' action='".url('matched-visa')."'>".csrf_field()."<input type='hidden' name='visa_ids' value='".implode(",",$match_visa)."'> </form>";
                $response['html'] = $html;
            }else{
                $response['match_found'] = 'no';
                $html = "<form id='response-form' method='post' formtarget='_blank' action='".url('eligibility-failed')."'>".csrf_field()."<input type='hidden' name='visa_id' value='".$visa_type_id."'> </form>";
                $response['html'] = $html;
            }
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function linkedQuestion(Request $request){
        try{
            $question_id = $request->input("question_id");
            $value = $request->input("value");
            $all_criteria = QuestionCreteria::where("linked_question",$question_id)->get();
            $criteria = array();
            $linked_questions = array();
            foreach($all_criteria as $crt){
                $options = json_decode($crt->conditional_option,true);
                if(in_array($value,$options)){
                    $criteria = $crt;
                    $linked_questions[] = $crt;
                }
            }
            if(!empty($criteria) && $criteria->conditional_option != ''){
                $criteria->conditional_option = json_decode($criteria->conditional_option,true);
            }
            $response['criteria'] = $criteria;
            $response['linked_questions'] = $linked_questions;
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function eligibilityQuestions(Request $request){
        $step = $request->input("step");
        $visa_id = $request->input("visa_id");

        $steps = EligibilitySteps::where("visa_type_id",$visa_id)->first();
        $sequence = json_decode($steps->sequence,true);
        if($step >= count($sequence)){
            $response['status'] = true;
            $response['is_finish'] = 'finish';
            $response['ques_count'] = 0;
            $response['total_step'] = count($sequence);
            $response['ques_ids'] = array();
            $response['current_step'] = $step-1;
            return response()->json($response);
        }
        $index = $step;
        $ques_ids = $sequence[$index];
        $linked_question = array();
        $new_ques = array();
        $prefill_values = array();
        $fid = array();
        if($request->input("questions")){
            $ques_ans = $request->input("questions");
            $flag = 0;
            for($i=0;$i < count($ques_ids);$i++){
                $ques = EligibilityQuestions::where("id",$ques_ids[$i])->first();
                if(!empty($ques->LinkedTo)){
                    $linked_to = $ques->LinkedTo->toArray();
                    if(isset($ques_ans[$linked_to['linked_question']])){
                        $opts = json_decode($linked_to['conditional_option'],true);
                        // echo $ques_ans[$linked_to['linked_question']];
                        $flag = 1;
                        if(in_array($ques_ans[$linked_to['linked_question']],$opts)){
                            $new_ques[] = $ques_ids[$i];
                            $fid[] = $ques_ids[$i];
                        }else{
                            $new_ques[] = $ques_ids[$i];
                        }
                    }
                }else{
                    $new_ques[] = $ques_ids[$i];
                    $fid[] = $ques_ids[$i];
                }
            }
            if($flag == 1){
                $ques_ids = $new_ques;
            }
            $prefill_values = $request->input("questions");
        }else{
            $fid = $ques_ids;
        }
        $questions = array();

        for($i=0;$i < count($ques_ids);$i++){
            $question = EligibilityQuestions::with('LinkedQuestion')
                                    ->with('Options')
                                    ->where("id",$ques_ids[$i])
                                    ->first();
            $questions[] = $question;
        }
        $viewData['prefill_values'] = $prefill_values;
        $viewData['questions'] = $questions;
        $viewData['ques_ids'] = $ques_ids;

        $viewData['new_ques'] = $new_ques;
        $viewData['step'] = $step;
        $view = View::make('front.modal.eligibility-question',$viewData);
        $contents = $view->render();
        $next_step = $step+1;
        if($next_step > count($sequence)){
            $next_step = count($sequence);
        }
        $response['status'] = true;
        $response['contents'] = $contents;
        $response['ques_count'] = count($fid);
        $response['total_step'] = count($sequence);
        $response['ques_ids'] = $ques_ids;
        $response['is_finish'] = 'next';
        $response['current_step'] = $next_step;
        return response()->json($response);
    }
    public function checkScore($slug){
        $visa_type = VisaTypes::with('VisaDocuments')->where("slug",$slug)->first();
        $steps = EligibilitySteps::where("visa_type_id",$visa_type->id)->first();
        
        $eligibility_questions = array();
        if(!empty($steps) && $steps->sequence != ''){
            $sequence = json_decode($steps->sequence,true);

            for($i=0;$i < count($sequence);$i++){
                for($j=0;$j < count($sequence[$i]);$j++){
                    

                    $questions = EligibilityQuestions::with('LinkedQuestion')
                                    ->with('Options')
                                    ->where("id",$sequence[$i][$j])
                                    ->first();
                   

                    if(!empty($questions)){
                        if(!empty($questions->LinkedQuestion)){
                            $linked_questions = $questions->LinkedQuestion;
                            $is_linked = 0;
                            foreach($linked_questions as $ques){
                                if($sequence[$i][$j] == $ques->question_id){
                                    $is_linked = 1;
                                }
                                // echo $questions->id." - ".$sequence[$i][$j]." - ".$ques->question_id."<br>";
                            }
                            
                            if($is_linked == 0){
                                $qids[] = $sequence[$i][$j];    
                                $eligibility_questions[$i][] = $questions;
                            }
                        }else{
                            $qids[] = $sequence[$i][$j];
                            $eligibility_questions[$i][] = $questions;
                        }
                    }
                }
            }
        }else{
            return Redirect::back()->with("error","No eligibility question set for score");
        }
        if(isset($eligibility_questions[0])){
            $viewData['eligibility_questions'] = $eligibility_questions[0];
        }else{
            $viewData['eligibility_questions'] = array();
        }
        $viewData['pageTitle'] = $visa_type->title;
        $viewData['bodyClass'] = 'visa-detail';
        $viewData['visa_type'] = $visa_type;
        return view('front.check-score',$viewData);
    }
    public function verifyScore($visa_type_id,Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone_no' => 'required',
                'questions' => 'required',
            ]);

            if ($validator->fails()) {
                $response['status'] = false;
                $error = $validator->errors()->toArray();
                $errMsg = '';
                foreach($error as $err){
                    $errMsg .= $err[0];
                }
                $response['message'] = $errMsg;
                return response()->json($response);
            }
            $visa_type_id = base64_decode($visa_type_id);
            
            $questions = $request->input("questions");
            $score = 0;
            $question_score = array();
            // pre($questions);
            $ques_score = array();
            $score_count = array();
            foreach($questions as $key => $value){
                if($value != ''){
                    $option = QuestionOptions::where("question_id",$key)
                                ->where("value",$value)
                                ->first();
                    if(!empty($option)){
                        $score += $option->score;
                    }else{
                        $score += 0;
                    }

                    $temp['question_id'] = $key;
                    $temp['answer'] = $value;
                    $temp['score'] = $option->score;
                    $ques_score[$key]['score'] = $option->score;
                    $ques_score[$key]['answer'] = $value;
                    $question_score[] = $temp;
                }else{
                    $score += 0;
                }
            }
            // pre($ques_score);

            $final_score = $score;
            $combinations = QuestionCombination::where("visa_type_id",$visa_type_id)->get();
            // echo count($combinations)."<br>";
            if(!empty($combinations)){
                foreach($combinations as $comb){
                    $temp = $comb->toArray();   
                    
                    if(isset($ques_score[$temp['question_id_one']]) && isset($ques_score[$temp['question_id_two']])){
                        $answer1 = $ques_score[$temp['question_id_one']]['answer'];
                        $answer2 = $ques_score[$temp['question_id_two']]['answer'];

                        $score1 = $ques_score[$temp['question_id_one']]['score'];
                        $score2 = $ques_score[$temp['question_id_two']]['score'];


                        if($answer1 == $temp['option_id_one'] && $answer2 == $temp['option_id_two']){
                            
                            $sum = $score1 + $score2;
                            $final_score -= $sum;
                            $new_sum = 0;
                           
                            if($temp['behaviour'] == 'substract'){
                                $new_sum = $sum - $temp['score'];
                            }
                            if($temp['behaviour'] == 'add'){
                                $new_sum = $sum + $temp['score'];
                            }
                            if($temp['behaviour'] == 'overwrite'){
                                $new_sum = $temp['score'];
                            }
                            $final_score += $new_sum;
                        }
                    }
                }
            }
            // pre($ques_score);
            $group_scores = QuestionGroups::with('SubQuestions')->where("visa_type_id",$visa_type_id)->get();
            $min_score_failed = '';
            if(!empty($group_scores)){
                foreach($group_scores->toArray() as $ques){
                    // pre($ques);
                    $sub_questions = $ques['sub_questions'];
                    $gscore = 0;

                    foreach($sub_questions as $sub_ques){
                        if(isset($ques_score[$sub_ques['question_id']])){
                            $gscore += $ques_score[$sub_ques['question_id']]['score'];
                        }
                    }
                    if($gscore < $ques['group_min_score']){
                        $min_score_failed .= "<h4>".$ques['group_heading']." minimum required score is ".$ques['group_min_score']." obtained score is ".$gscore."</h4><p>Below are the question</p><ul>";
                        foreach($sub_questions as $sub_ques){
                            $min_score_failed .= "<li>".$sub_ques['question']['question']."</li>";
                        }
                        $min_score_failed .= "</ul>";
                    }
                    if($gscore > $ques['group_max_score']){
                        $score_diff = $gscore - $ques['group_max_score'];
                        $final_score -= $score_diff;
                    }
                    // echo "Min Score: ".$ques['group_min_score']."<br>";
                    // echo "Max Score: ".$ques['group_max_score']."<br>";
                    // echo "Obtain Score: ".$gscore."<br><br><hr>";
                }                
            }
            if($min_score_failed != ''){
                $response['status'] = false;
                $response['eligibility_error'] = true;
                $response['error_message'] = $min_score_failed;
                return response()->json($response);
            }
            $object = new EligibilityCheck();
            $object->first_name = $request->input("first_name");
            $object->last_name = $request->input("last_name");
            $object->email = $request->input("email");
            $object->phone_no = $request->input("phone_no");
            $object->visa_type = $visa_type_id;
            $object->response = json_encode($question_score);
            $object->type = 'score';
            $object->score = $final_score;
            $object->save();
            $id = $object->id;
            $response['status'] = true;

            $html = "<form id='response-form' method='post' formtarget='_blank' action='".url('visa-score')."'>".csrf_field()."<input type='hidden' name='score_id' value='".$id."'> </form>";
            $response['html'] = $html;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function matchedVisa(Request $request){
      
        $visa_ids = explode(",",$request->input("visa_ids"));
        $visa_types = VisaTypes::whereIn("id",$visa_ids)->get();
        $viewData['pageTitle'] = "Matched Visa";
        $viewData['bodyClass'] = 'visa-services';
        $viewData['visa_types'] = $visa_types;
        return view('front.matched-visa',$viewData);
    }
    public function visaScore(Request $request){
        $score_id = $request->input("score_id");
        $visa_score = EligibilityCheck::where("id",$score_id)->first();
        $viewData['pageTitle'] = "Visa Score";
        $viewData['bodyClass'] = 'visa-score';
        $viewData['visa_score'] = $visa_score;
        $response = json_decode($visa_score->response,true);
        $questions = array();
        foreach($response as $res){
            $ques = EligibilityQuestions::with('Options')->where("id",$res['question_id'])->first();
            $temp = $res;
            $temp['question'] = $ques->toArray();
            $questions[] = $temp;
        }
        $viewData['questions'] = $questions;
        return view('front.visa-score',$viewData);
    }
    public function viewScore($score_id){
        $visa_score = EligibilityCheck::where("id",$score_id)->first();
        $viewData['pageTitle'] = "Visa Score";
        $viewData['bodyClass'] = 'visa-score';
        $viewData['visa_score'] = $visa_score;
        $response = json_decode($visa_score->response,true);
        $questions = array();
        foreach($response as $res){
            $ques = EligibilityQuestions::with('Options')->where("id",$res['question_id'])->first();
            $temp = $res;
            $temp['question'] = $ques->toArray();
            $questions[] = $temp;
        }
        $viewData['questions'] = $questions;
        return view('front.view-score',$viewData);
    }
    public function eligibilityFailed(Request $request){
        $visa_id = $request->input("visa_id");

        $default_visa = DefaultVisaType::where("visa_type_id",$visa_id)->first();
       
        if(!empty($default_visa)){
            $visa_type_ids = json_decode($default_visa->default_visa,true);
            $visa_types = VisaTypes::whereIn("id",$visa_type_ids)->get();
            $viewData['visa_types'] = $visa_types;
            $viewData['default_visa'] = $default_visa;
        }
        $viewData['pageTitle'] = "Eligibility Failed";
        $viewData['bodyClass'] = 'visa-services';
        
        return view('front.eligibility-failed',$viewData);
    }
    
    public function business(){
        $viewData['pageTitle'] = "Business";
        $viewData['bodyClass'] = 'business';
        $categories = BusinessCategory::get();
        $viewData['categories'] = $categories;
        $visa_types = VisaTypes::get();
        $viewData['visa_types'] = $visa_types;
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        return view('front.business.business',$viewData);
    }    

    public function businessList(Request $request){
        // $sort_by = $request->input("sort_by");
        // $article_by = $request->input("article_by");
        // $slug = $request->input("slug");
        $postData = $request->input();
        $column = "title";
        $order = "asc";
        // if($sort_by != ''){
        //     if($sort_by == 'date_desc'){
        //         $column = "created_at";    
        //         $order = "desc";
        //     }
        //     if($sort_by == 'date_asc'){
        //         $column = "created_at";    
        //         $order = "asc";
        //     }
        //     if($sort_by == 'title_asc'){
        //         $column = "title";    
        //         $order = "asc";   
        //     }
        //     if($sort_by == 'title_desc'){
        //         $column = "title";    
        //         $order = "desc";  
        //     }
        // }
        $records = Business::where(function($query) use($postData){
                                if(isset($postData['country_id'])){
                                    $query->where("country_id",$postData['country_id']);
                                }
                                if(isset($postData['state_id'])){
                                    $query->where("state_id",$postData['state_id']);
                                }
                                if(isset($postData['city_id'])){
                                    $query->where("city_id",$postData['city_id']);
                                }
                                if($postData['ap_min'] != ''){
                                    $query->where("asking_price",">=",$postData['ap_min']);
                                }
                                if($postData['ap_max'] != ''){
                                    $query->where("asking_price","<=",$postData['ap_max']);
                                }
                                if($postData['sr_min'] != ''){
                                    $query->where("sales_revenue",">=",$postData['sr_min']);
                                }
                                if($postData['sr_max'] != ''){
                                    $query->where("sales_revenue","<=",$postData['sr_max']);
                                }
                                if($postData['cf_min'] != ''){
                                    $query->where("cash_flow",">=",$postData['cf_min']);
                                }
                                if($postData['cf_max'] != ''){
                                    $query->where("cash_flow","<=",$postData['cf_max']);
                                }
                                if(isset($postData['category'])){
                                    $query->whereIn("category_id",$postData['category']);
                                }
                                if(isset($postData['tags'])){
                                    $tags = $postData['tags'];
                                    $query->whereHas("BusinessTags",function($q) use($tags){
                                        $q->whereIn("tag_id",$tags);
                                    });
                                }
                            })
                            ->orderBy($column,$order)
                            ->paginate();
        
        $viewData['businesses'] = $records;
        $viewData['current_page'] = (string) $records->currentPage();
        $viewData['last_page'] = (string) $records->lastPage();
        $viewData['total_records'] = (string) $records->total();
        $view = View::make('front.business.business-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['paginate'] = (string) $records->links();
        $response['page_info'] = paginateInfo($records);
       
        return response()->json($response);
    }

    public function businessDetail($slug){
        $business = Business::with('BusinessTags')->where("slug",$slug)->first();
        $viewData['pageTitle'] = $business->title;
        $viewData['bodyClass'] = 'business';
        
        $viewData['record'] = $business;
        return view('front.business.business-detail',$viewData);
    }

    
}
