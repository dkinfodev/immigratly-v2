<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\AppointmentTypes;
use App\Models\TimeDuration;

class TimeDurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Time Duration";
        $viewData['activeTab'] = 'time-duration';
        return view(roleFolder().'.time-duration.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = TimeDuration::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("name","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.time-duration.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
    
    public function add(){
        $viewData['pageTitle'] = "Add Time Duration";
        $view = View::make(roleFolder().'.time-duration.modal.add-schedule',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }


    public function save(Request $request){
        // pre($request->all());
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'duration'=>'required',
            'type'=>'required',
            'break_time'=>'numeric',
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
     
        $object = new TimeDuration();
        $object->unique_id = randomNumber();
        $object->name = $request->input("name");
        $object->duration = $request->input("duration");
        $object->type = $request->input("type");
        $object->break_time = $request->input("break_time");
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('time-duration');
        $response['message'] = "Schedule added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $viewData['pageTitle'] = "Edit Time Duration";

        $viewData['activeTab'] = 'time-duration';

        $id = base64_decode($id);
        $record = TimeDuration::find($id);
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.time-duration.modal.edit-schedule',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  TimeDuration::find($id);

        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'duration'=>'required',
            'type'=>'required',
            'break_time'=>'numeric',
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
        $object->type = $request->input("type");
        $object->break_time = $request->input("break_time");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('appointment-types');
        $response['message'] = "Record updated successfully";

        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        TimeDuration::deleteRecord($id);
        
        // \Session::flash('success', 'Records deleted successfully'); 
        return redirect()->back()->with('error',"Record deleted successfully");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            TimeDuration::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }


}
