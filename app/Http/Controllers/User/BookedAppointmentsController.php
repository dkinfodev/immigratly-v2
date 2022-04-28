<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\BookedAppointments;
use App\Models\Professionals;
class BookedAppointmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
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
        $records = BookedAppointments::orderBy('id',"desc")
                        ->where("user_id",\Auth::user()->unique_id)
                        ->paginate(5);

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.booked-appointments.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
    
    
    public function delete($id){
        BookedAppointments::where("unique_id",$id)->delete();
        return redirect()->back()->with("success","Appointment deleted successfully");     
    }

    public function viewAppointment($appointment_id){
        $appointment = BookedAppointments::where("unique_id",$appointment_id)->first();
        $subdomain = $appointment->professional;
        $visa_service = professionalService($subdomain,$appointment->visa_service_id,'unique_id');
        $company_data = professionalDetail($subdomain);
        $professionalAdmin = professionalAdmin($subdomain);
        $professional_location = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_locations")->where('unique_id',$appointment->location_id)->first();
        $professional = Professionals::where('subdomain',$subdomain)->first();
        $viewData['professional_location'] = $professional_location;
        $viewData['pageTitle'] = "View Appointment";
        $viewData['service'] = $visa_service;
        $viewData['company_data'] = $company_data;
        $viewData['professionalAdmin'] = $professionalAdmin;
        $viewData['appointment'] = $appointment;
        $viewData['subdomain'] = $subdomain;
        return view(roleFolder().'.booked-appointments.view-appointment',$viewData);
    }
}
