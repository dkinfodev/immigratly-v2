<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\ProfessionalLocations;

class LocationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $viewData['pageTitle'] = "Locations";
        $viewData['activeTab'] = 'locations';
        return view(roleFolder().'.locations.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = ProfessionalLocations::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("address","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.locations.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
    
    public function add(){
        $viewData['pageTitle'] = "Add Location";
        $view = View::make(roleFolder().'.locations.modal.add-location',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }


    public function save(Request $request){
        // pre($request->all());
        $validator = Validator::make($request->all(), [
            'address'=>'required',
            'type'=>'required',
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
        $object = new ProfessionalLocations();
        $object->unique_id = randomNumber();
        $object->address = $request->input("address");
        $object->type = $request->input("type");
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('locations');
        $response['message'] = "Location added sucessfully";
        
        return response()->json($response);
    }
 
    public function edit($id,Request $request){
        $viewData['pageTitle'] = "Edit Location";
        $id = base64_decode($id);
        $record = ProfessionalLocations::find($id);
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.locations.modal.edit-location',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }


    public function update($id,Request $request){
        // pre($request->all());
        $id = base64_decode($id);
        $object =  ProfessionalLocations::find($id);

        $validator = Validator::make($request->all(), [
            'address'=>'required',
            'type'=>'required',
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

        $object->address = $request->input("address");
        $object->type = $request->input("type");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('locations');
        $response['message'] = "Record updated successfully";

        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        ProfessionalLocations::deleteRecord($id);
        
        // \Session::flash('success', 'Records deleted successfully'); 
        return redirect()->back()->with('error',"Record deleted successfully");
    }

    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            ProfessionalLocations::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }


}
