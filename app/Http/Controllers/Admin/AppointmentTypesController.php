<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\AppointmentTypes;
use App\Models\AppointmentServicePrice;


class AppointmentTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Appointment Types";
        $viewData['activeTab'] = 'appointment-types';
        return view(roleFolder().'.appointment-types.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = AppointmentTypes::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.appointment-types.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
    
    public function add(){
        $viewData['pageTitle'] = "Add Appointment Type";
        $view = View::make(roleFolder().'.appointment-types.modal.add-schedule',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }


    public function save(Request $request){
        // pre($request->all());
        $validator = Validator::make($request->all(), [
            'name'=>'required',
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
        $object = new AppointmentTypes();
        $object->unique_id = randomNumber();
        $object->name = $request->input("name");
        $object->duration = $request->input("duration");
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('appointment-types');
        $response['message'] = "Schedule added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $viewData['pageTitle'] = "Edit Appointment Type";
        $id = base64_decode($id);
        $record = AppointmentTypes::find($id);
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.appointment-types.modal.edit-schedule',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  AppointmentTypes::find($id);

        $validator = Validator::make($request->all(), [
            'name'=>'required',
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
        $id = \Auth::user()->id;

        $object->name = $request->input("name");
        $object->duration = $request->input("duration");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('appointment-types');
        $response['message'] = "Record updated successfully";

        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        AppointmentTypes::deleteRecord($id);
        
        // \Session::flash('success', 'Records deleted successfully'); 
        return redirect()->back()->with('error',"Record deleted successfully");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            AppointmentTypes::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }


    public function appointmentServicePrice($appointment_type_id){
        $appointment_type =  AppointmentTypes::where("unique_id",$appointment_type_id)->first();
        $services = ProfessionalServices::orderBy('id',"desc")->get();
        $service_prices = AppointmentServicePrice::where("appointment_type_id",$appointment_type_id)->pluck("price","visa_service_id");
        if(!empty($service_prices)){
            $service_prices = $service_prices->toArray();
        }else{
            $service_prices = array();
        }
        $viewData['pageTitle'] = "Set Price for Visa Services";
        $viewData['activeTab'] = 'appointment-types';
        $viewData['services'] = $services;
        $viewData['service_prices'] = $service_prices;
        $viewData['appointment_type'] = $appointment_type;
        return view(roleFolder().'.appointment-types.appointment-service-price',$viewData);
    }

    public function saveAppointmentServicePrice($appointment_type_id, Request $request){
        $services = $request->input("service_price");
        $ids = array();
        foreach($services as $key => $value){
            $object = AppointmentServicePrice::updateOrCreate(['appointment_type_id'=>$appointment_type_id,'visa_service_id'=>$key],
                                                              [
                                                                  'appointment_type_id'=>$appointment_type_id,'visa_service_id'=>$key,
                                                                   "price"=>$value,"created_at"=>date("Y-m-d H:i:s"),"updated_at"=>date("Y-m-d H:i:s")
                                                              ]);
            $ids[] = $object->id;
        }
        if(!empty($ids)){
            AppointmentServicePrice::where("appointment_type_id",$appointment_type_id)->whereNotIn("id",$ids)->delete();
        }else{
            AppointmentServicePrice::where("appointment_type_id",$appointment_type_id)->delete();
        }
        

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('appointment-types');
        $response['message'] = "Price saved successfully";

        return response()->json($response);
    }

}
