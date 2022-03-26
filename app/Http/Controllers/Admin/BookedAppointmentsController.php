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
    public function viewCalendar()
    {
        $viewData['pageTitle'] = "Booked Appointments";
        $viewData['activeTab'] = 'booked-appointments';
        $viewData['professional'] = \Session::get("subdomain");
        return view(roleFolder().'.booked-appointments.calendar',$viewData);
    } 
    public function fetchAppointments(Request $request){
        $month = $request->input("month");
        $year = $request->input("year");
        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");
        $professional = $request->input("professional");
        
        $day_schedules = array();
        $apiData['professional'] = \Session::get("subdomain");
        $apiData['start_date'] = $start_date;
        $apiData['end_date'] = $end_date;
        $apiData['response_type'] = "date_counter";
        $result = curlRequest("booked-appointments/fetch-appointments",$apiData);
        if($result['status'] == 'success'){
            $appointments = $result['data'];
        }else{
            $appointments = array();
        }
        $dates = getBetweenDates($start_date,$end_date);
        
        for($d=0;$d < count($dates);$d++){
            $day = date("l",strtotime($dates[$d]));
            foreach($appointments as $appointment){
                if($appointment['appointment_date'] == $dates[$d]){
                    $temp = array();
                    $temp['start'] = $dates[$d];
                    $temp['title'] = $appointment['total_appointment']. " Appointment(s) \n are booked";
                    $temp['className'] = 'text-primary booked-appointment';
                    $day_schedules[] = $temp;
                }
            }
        }
        $response['status'] = true;
        $response['schedule'] = $day_schedules;

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
