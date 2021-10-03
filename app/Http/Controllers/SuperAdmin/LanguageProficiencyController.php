<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

use App\Models\LanguageProficiency;
use App\Models\LanguageScoreChart;
use App\Models\OfficialLanguages;

class LanguageProficiencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('super_admin');
    }

    public function index()
    {
        $viewData['total_bodies'] = LanguageProficiency::count();
        $viewData['pageTitle'] = "Language Proficiency";
        return view(roleFolder().'.language-proficiency.lists',$viewData);
    } 

    public function getAjaxList(Request $request)
    {
        $keyword = $request->input("search");
        $records = LanguageProficiency::where(function($query) use($keyword){
                                    if($keyword != ''){
                                        $query->where("name","LIKE",$keyword."%");
                                    }
                                })
                                ->orderBy('id',"desc")
                                ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.language-proficiency.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function add(){
        $viewData['pageTitle'] = "Add Language Proficiency";
        $official_languages = OfficialLanguages::get();
        $viewData['official_languages'] = $official_languages;
        return view(roleFolder().'.language-proficiency.add',$viewData);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:language_proficiency',
        ]);
        
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['error_type'] = 'validation';
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $clb_level = $request->input("clb_level");
        foreach($clb_level as $key => $level){
            if($level['clb_level'] == ''){
                $response['status'] = false;
                $response['error_type'] = 'clb_error';
                $response['message'] = "CLB Level must not be blank";
                return response()->json($response);
            }
        }
        $unique_id = randomNumber();
        $object =  new LanguageProficiency;
        $object->name = $request->input("name");
        $object->official_language = $request->input("official_language");
        $object->unique_id = $unique_id;
        $object->added_by = \Auth::user()->unique_id;
        $object->save();
        
        foreach($clb_level as $key => $level){
            $obj = new LanguageScoreChart();
            $obj->language_proficiency_id = $unique_id;
            $obj->unique_id = randomNumber();;
            $obj->clb_level = $level['clb_level'];
            $obj->reading = $level['reading'];
            $obj->writing = $level['writing'];
            $obj->listening = $level['listening'];
            $obj->speaking = $level['speaking'];
            $obj->save();
        }

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('language-proficiency');
        $response['message'] = "Record added successfully";
        
        return response()->json($response);
    }


    public function edit($id){
        $id = base64_decode($id);
        $viewData['record'] = LanguageProficiency::where("id",$id)->first();
        $viewData['pageTitle'] = "Edit Language Proficiency";
        $official_languages = OfficialLanguages::get();
        $viewData['official_languages'] = $official_languages;
        return view(roleFolder().'.language-proficiency.edit',$viewData);
    }

    public function update($id,Request $request){

        $id = base64_decode($id);
        $object =  LanguageProficiency::find($id);
        $language_proficiency_id = $object->unique_id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:language_proficiency,name,'.$object->id,
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
        if(!$request->input("clb_level")){
            $response['status'] = false;
            $response['error_type'] = 'clb_error';
            $response['message'] = "CLB Level required";
            return response()->json($response);
        }
        $clb_level = $request->input("clb_level");
        foreach($clb_level as $key => $level){
            if($level['clb_level'] == ''){
                $response['status'] = false;
                $response['error_type'] = 'clb_error';
                $response['message'] = "CLB Level must not be blank";
                return response()->json($response);
            }
        }
        $object->name = $request->input("name");
        $object->official_language = $request->input("official_language");
        $object->save();
        
        LanguageScoreChart::where("language_proficiency_id",$language_proficiency_id)->delete();
        foreach($clb_level as $key => $level){
            $obj = new LanguageScoreChart();
            $obj->language_proficiency_id = $language_proficiency_id;
            $obj->unique_id = randomNumber();;
            $obj->clb_level = $level['clb_level'];
            $obj->reading = $level['reading'];
            $obj->writing = $level['writing'];
            $obj->listening = $level['listening'];
            $obj->speaking = $level['speaking'];
            $obj->save();
        }

        $response['status'] = true;
        $response['redirect_back'] = baseUrl('/language-proficiency');
        $response['message'] = "Record updated successfully";
       
        return response()->json($response);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        LanguageProficiency::deleteRecord($id);
        return redirect()->back()->with("success","Record deleted successfully");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            LanguageProficiency::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }
    public function search($keyword){
        $keyword = $keyword;
        
        $records = LanguageProficiency::where("name" , 'LIKE' , "%$keyword%")->paginate();

        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.language-proficiency.data',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
}
