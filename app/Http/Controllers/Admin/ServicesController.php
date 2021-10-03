<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\ProfessionalServices;
use App\Models\ServiceDocuments;

class ServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request){
       	$viewData['pageTitle'] = "Services";
        $service_ids = ProfessionalServices::pluck("service_id");
        if(!empty($service_ids) > 0){
            $service_ids = $service_ids->toArray();
        }
        $main_services = DB::table(MAIN_DATABASE.".visa_services")
                                        ->where('parent_id',0)
                                        ->where(function($query) use($service_ids){
                                            if(count($service_ids) > 0){
                                                $query->whereNotIn("id",$service_ids);
                                            }
                                        })
                                        ->get();
        $all_services = array();
        foreach($main_services as $service){
            $temp = array();
            $temp = $service;
            $sub_services = DB::table(MAIN_DATABASE.".visa_services")
                                        ->where('parent_id',$service->id)
                                        ->where(function($query) use($service_ids){
                                            if(count($service_ids) > 0){
                                                $query->whereNotIn("id",$service_ids);
                                            }
                                        })
                                        ->get();
            if(!empty($sub_services)){
                $temp->sub_services = $sub_services;
            }else{
                $temp->sub_services = array();
            }
            $all_services[] = $service;
        }
        $viewData['all_services'] = $all_services;
        $my_services = ProfessionalServices::orderBy('id',"desc")->get();

        $viewData['my_services'] = $my_services;

        return view(roleFolder().'.services.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $records = ProfessionalServices::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.services.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function edit($id,Request $request){
        $id = base64_decode($id);
        $viewData['pageTitle'] = "Edit Service";
        $record = ProfessionalServices::where("id",$id)->first();
        $viewData['record'] = $record;
        return view(roleFolder().'.services.edit',$viewData);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(), [
            'price' => 'required',
            'description' => 'required',
        ]);
        $id = base64_decode($id);
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
        $object =  ProfessionalServices::find($id);
        $object->price = $request->input("price");
        $object->description = $request->input("description");
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('services');
        $response['message'] = "Record edited successfully";
        
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        ProfessionalServices::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            ProfessionalServices::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function selectServices(Request $request){
        $validator = Validator::make($request->all(), [
            'services' => 'required',
        ]);
        
        if ($validator->fails()) {   
            return redirect()->back()->withErrors($validator->errors());
        }

        $services = $request->input('services');
        for($i=0;$i < count($services);$i++){
            $check_if_exists = ProfessionalServices::where("service_id",$services[$i])->count();
            if($check_if_exists <= 0){
                $object = new ProfessionalServices();
                $object->unique_id = randomNumber();
                $object->service_id = $services[$i];
                $object->save();
            }
        }
        return redirect()->back()->with("success","Services selected successfully");
    }

    public function serviceDocuments($id){
        $id = base64_decode($id);
        $service = ProfessionalServices::where("id",$id)->first();
        $documents = ServiceDocuments::where("service_id",$id)->get();
        $viewData['documents'] = $documents;
        $viewData['service'] = $service;
        $viewData['pageTitle'] = "Documents of ".$service->Service($service->service_id)->name;
        return view(roleFolder().'.services.document-folders',$viewData);
    }

    public function addFolder($id,Request $request){
        // $id = base64_decode($id);
        $viewData['service_id'] = $id;
        $viewData['pageTitle'] = "Add Folder";
        $view = View::make(roleFolder().'.services.modal.add-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function createFolder($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $id = base64_decode($id);
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
        $object = new ServiceDocuments();
        $object->service_id = $id;
        $object->unique_id = randomNumber();
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder added successfully";
        
        return response()->json($response);
    }

    public function editFolder($id,Request $request){
        $id = base64_decode($id);
        $record = ServiceDocuments::find($id);
        $viewData['service_id'] = $id;
        $viewData['pageTitle'] = "Edit Folder";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.services.modal.edit-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function updateFolder($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $id = base64_decode($id);
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
        $object = ServiceDocuments::find($id);
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder edited successfully";
        
        return response()->json($response);
    }

    public function deleteFolder($id){
        $id = base64_decode($id);
        ServiceDocuments::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
}
