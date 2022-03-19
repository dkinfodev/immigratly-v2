<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;


class BookedAppointmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Booked Appointments";
        $viewData['activeTab'] = 'booked-appointments';
        return view(roleFolder().'.booked-appointments.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['search'] = $search;
        if($request->get("page")){
            $page = $request->get("page");
        }else{
            $page = 1;
        }
       
        $result = curlRequest("booked-appointments?page=".$page,$apiData);
        
        $viewData = array();
        if($result['status'] == 'success'){
            $viewData['records'] = $result['data'];
            
            $response['last_page'] = $result['last_page'];
            $response['current_page'] = $result['current_page'];
            $response['total_records'] = $result['total_records'];
        }else{
            $viewData['records'] = array();
        }
  
        $view = View::make(roleFolder().'.booked-appointments.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        return response()->json($response);
    }
    
    
    public function changeStatus($id,$status){
        $apiData['subdomain'] = \Session::get("subdomain");
        $apiData['id'] = $id;
        $apiData['status'] = $status;
        $result = curlRequest("booked-appointments/change-status",$apiData);
        
        $viewData = array();
        if($result['status'] == 'success'){
            return redirect()->back()->with("success","Booking status changed successfully");
        }else{
            return redirect()->back()->with("error","Something wents wrong");
        }        
    }

}
