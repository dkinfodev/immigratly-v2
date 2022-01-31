<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\User;
use App\Models\LicenceBodies;
use App\Models\Countries;

class LicenceBodiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function licenceBodies()
    {
        $viewData['total_bodies'] = LicenceBodies::count();
        //$viewData['records'] = LicenceBodies::count();
        $viewData['pageTitle'] = "Licence Bodies";
        $viewData['activeTab'] = 'licence-bodies';
        return view(roleFolder().'.licence-bodies.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $keyword = $request->input("search");
        $records = LicenceBodies::where(function($query) use($keyword){
                                    if($keyword != ''){
                                        $query->where("name","LIKE",$keyword."%");
                                    }
                                })
                                ->orderBy('id',"desc")
                                ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.licence-bodies.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        $viewData['activeTab'] = 'licence-bodies';
        $viewData['pageTitle'] = "Add Licence Bodies";
        return view(roleFolder().'.licence-bodies.add',$viewData);
    }


    public function save(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
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
        
        $object =  new LicenceBodies;
        $object->name = $request->input("name");
        $object->country_id = $request->input("country_id");
        $object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('licence-bodies');
        
        $response['message'] = "Record added successfully";
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = LicenceBodies::where("id",$id)->first();
        $countries = Countries::get();
        $viewData['countries'] = $countries;
        $viewData['pageTitle'] = "Edit Licence Body";
        $viewData['activeTab'] = 'licence-bodies';
        return view(roleFolder().'.licence-bodies.edit',$viewData);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'country_id' => 'required',
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

        $id = base64_decode($id);
        $object =  LicenceBodies::find($id);
        $object->name = $request->input("name");
        $object->country_id = $request->input("country_id");
        $object->save();

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/licence-bodies');

        $response['message'] = "Record updated successfully";
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        LicenceBodies::deleteRecord($id);
        return redirect()->back()->with('success',"Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            LicenceBodies::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function search($keyword){
        $keyword = $keyword;
        $records = LicenceBodies::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.licence-bodies.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

}
