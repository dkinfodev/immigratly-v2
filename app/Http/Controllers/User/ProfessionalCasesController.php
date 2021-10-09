<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\User;
use App\Models\Countries;
use App\Models\Languages;
use App\Models\UserWithProfessional;
use App\Models\UserFolders;
use App\Models\UserFiles;
use App\Models\FilesManager;
use App\Models\UserDetails;

class ProfessionalCasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    
    public function cases()
    {
       	$viewData['pageTitle'] = "Cases";
        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)->get();
       
        $viewData['professionals'] = $professionals;
        return view(roleFolder().'.cases.lists',$viewData);
    }
    
    public function view($subdomain,$case_id){
        $data['case_id'] = $case_id;
        $data['client_id'] = \Auth::user()->unique_id;
        $case = professionalCurl('cases/view',$subdomain,$data);
        if(isset($case['status']) && $case['status'] == 'success'){
            $record = $case['data'];
        }else{
            $record = array();
        }
        
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "View Case";
        $viewData['record'] = $record;
        $viewData['active_nav'] = "overview";
        $viewData['visa_services'] = array();
        return view(roleFolder().'.cases.view',$viewData);
    } 

    public function caseDocuments($subdomain,$case_id){

        $data['case_id'] = $case_id;
        $case = professionalCurl('cases/documents',$subdomain,$data);
  
        $record = array();
        $service = array();
        $case_folders = array();
        $documents = array();
        $viewData['pageTitle'] = "Documents";
        $data = array();
        $data['case_id'] = $case_id;
        $data['client_id'] = \Auth::user()->unique_id;
        $case_view = professionalCurl('cases/view',$subdomain,$data);
        if(isset($case_view['status']) && $case_view['status'] == 'success'){
            $record = $case_view['data'];
        }else{
            $record = array();
        }
        if(isset($case['status']) && $case['status'] == 'success'){
            $case_data = $case['data'];
            $service = $case_data['service'];
            $case_folders = $case_data['case_folders'];
            $documents = $case_data['documents'];
            $viewData['pageTitle'] = "Documents for ".$service['MainService']['name'];
        }
        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        
        $user_file_url = userDirUrl()."/documents";
        $user_file_dir = userDir()."/documents";
        $viewData['user_file_url'] = $user_file_url;
        $viewData['user_file_dir'] = $user_file_dir;
        $viewData['user_folders'] = $user_folders;

        $viewData['case_id'] = $case_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['active_nav'] = "files";
        return view(roleFolder().'.cases.document-folders',$viewData);
    }

    public function fetchUserDocuments(Request $request){
        $folder_id = $request->input("doc_id");
        $case_id = $request->input("case_id");
        $subdomain = $request->input("subdomain");
        
        $document = UserFolders::where("unique_id",$folder_id)->first();
        $user_id = \Auth::user()->unique_id;
        
        $user_documents = UserFiles::with('FileDetail')
                                    ->join('files_manager', 'files_manager.unique_id', '=', 'user_files.file_id')
                                    ->where("user_files.folder_id",$folder_id)
                                    ->where("user_files.user_id",$user_id)
                                    ->select("user_files.*")
                                    ->orderBy("id","desc")
                                    ->get();
       
        $viewData['user_documents'] = $user_documents;
        $file_url = userDirUrl()."/documents";
        $file_dir = userDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['document'] = $document;
        $viewData['case_id'] = $case_id;
        $viewData['folder_id'] = $folder_id;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.fetch-user-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);      
    }

    public function fetchDocuments(Request $request){
        $doctype = $request->input("doctype");
        $subdomain = $request->input("subdomain");
        $case_id = $request->input("case_id");
        $doc_id = $request->input("doc_id");
        switch($doctype){
            case "default": // case default
                $response = $this->defaultDocuments($subdomain,$case_id,$doc_id,true);
                break;
            case "extra": // Professional
                $response = $this->extraDocuments($subdomain,$case_id,$doc_id,true);
                break;
            case "other": // case other
                $response = $this->otherDocuments($subdomain,$case_id,$doc_id,true);
                break;   
            default:
                $response['status'] = false;
                $response['message'] = "No data available";
                break;
        }
        return response()->json($response);
    }
    public function defaultDocuments($subdomain,$case_id,$doc_id,$returnView=false){
        
        $data['case_id'] = $case_id;
        $data['doc_id'] = $doc_id;
        $data['doc_type'] = "default";

        $record = array();
        $document = array();
        $case_documents = array();
        
        $api_response = professionalCurl('cases/default-documents',$subdomain,$data);
        
        $result = $api_response['data'];

        $service = $result['service'];
        $record = $result['record'];
        $case_documents = $result['case_documents'];
        $document = $result['document'];
        $folder_id = $document['unique_id'];
        
        $viewData['case_id'] = $case_id;
        $viewData['doc_id'] = $doc_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['pageTitle'] = "Files List for ".$document['name'];
        $viewData['record'] = $record;
        $viewData['doc_type'] = "default";

        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $viewData['user_detail'] = $user_detail;
        if($returnView == false){
            return view(roleFolder().'.cases.document-files',$viewData);
        }else{
            $view = View::make(roleFolder().'.cases.fetch-folder-files',$viewData);
            $contents = $view->render();
            $response['contents'] = $contents;
            $response['status'] = true;
            return $response;
        }
        
    }
    public function otherDocuments($subdomain,$case_id,$doc_id,$returnView=false){

        $data['case_id'] = $case_id;
        $data['doc_id'] = $doc_id;
        $data['doc_type'] = "default";

        $record = array();
        $document = array();
        $case_documents = array();
        
        $case = professionalCurl('cases/other-documents',$subdomain,$data);

        $result = $case['data'];

        $service = $result['service'];
        $record = $result['record'];
        $case_documents = $result['case_documents'];
        $document = $result['document'];
        $folder_id = $document['unique_id'];

        $viewData['case_id'] = $case_id;
        $viewData['doc_id'] = $doc_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Files List for ".$document['name'];
        $viewData['doc_type'] = "other";
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];

        

        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $user_detail = UserDetails::where("user_id",$user_id)->first();
        $viewData['user_detail'] = $user_detail;
        if($returnView == false){
            return view(roleFolder().'.cases.document-files',$viewData);
        }else{
            $view = View::make(roleFolder().'.cases.fetch-folder-files',$viewData);
            $contents = $view->render();
            $response['contents'] = $contents;
            $response['status'] = true;
            return $response;
        }
    }
    public function extraDocuments($subdomain,$case_id,$doc_id,$returnView=false){
        $user_id = \Auth::user()->unique_id;
        $data['case_id'] = $case_id;
        $data['doc_id'] = $doc_id;
        $data['doc_type'] = "extra";

        $record = array();
        $document = array();
        $case_documents = array();
        
        $api_response = professionalCurl('cases/extra-documents',$subdomain,$data);
        
        $result = $api_response['data'];

        $service = $result['service'];
        $record = $result['record'];
        $case_documents = $result['case_documents'];

        $document = $result['document'];
        $folder_id = $document['unique_id'];

        $viewData['case_id'] = $case_id;
        $viewData['doc_id'] = $doc_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Files List for ".$document['name'];
        $viewData['doc_type'] = "extra";
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;

        

        $user_detail = UserDetails::where("user_id",$user_id)->first();
        $viewData['user_detail'] = $user_detail;
        if($returnView == false){
            return view(roleFolder().'.cases.document-files',$viewData);
        }else{
            $view = View::make(roleFolder().'.cases.fetch-folder-files',$viewData);
            $contents = $view->render();
            
            $response['contents'] = $contents;
            $response['status'] = true;
            return $response;
        }
    }

    
    public function uploadDocuments($id,Request $request){
        $case_id = $id;
        $folder_id = $request->input("folder_id");
        $subdomain = $request->input("subdomain");

        $data['case_id'] = $case_id;
        $data['client_id'] = \Auth::user()->unique_id;
        $case = professionalCurl('cases/view',$subdomain,$data);
        $record = $case['data'];

        $document_type = $request->input("doc_type");
        $failed_files = array();
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        = randomNumber(5)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = professionalDir($subdomain)."/documents";

                if($file->move($destinationPath, $newName)){
                    $unique_id = randomNumber();

                    $insData['newName'] = $newName;
                    $insData['case_id'] = $case_id;
                    $insData['original_name'] = $fileName;
                    $insData['created_by'] = \Auth::user()->unique_id;
                    $insData['document_type'] = $document_type;
                    $insData['folder_id'] = $folder_id;

                    $api_response = professionalCurl('cases/upload-documents',$subdomain,$insData);
                    
                    if($api_response['status'] == 'success'){
                        $response['status'] = true;
                        $response['message'] = 'File uploaded!';
                    }else{
                        $response['status'] = false;
                        $response['message'] = 'File not uploaded!';
                    }
                }else{
                    $response['status'] = false;
                    $response['message'] = 'File not uploaded!';
                }
            }else{
                $response['status'] = false;
                $response['message'] = "File not allowed";
            }
            return response()->json($response);
        }
    }

    public function documentsExchanger($subdomain,$case_id){

        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        if($api_response['status'] == 'error'){
            return redirect(baseUrl('/cases'))->with("error",$api_response['message']);
        }
        $result = $api_response['data'];
        
        $record = $result['record'];
        $service = $result['service'];
        $documents = $result['documents'];
        $case_folders = $result['case_folders'];
        
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record['id'];
        $viewData['pageTitle'] = "Documents Exchanger";

        return view(roleFolder().'.cases.documents-exchanger',$viewData);
    }

    public function saveExchangeDocuments(Request $request){
        $doc_type = $request->input("document_type");
        $folder_id = $request->input("folder_id");
        $case_id = $request->input("case_id");
        $files = $request->input("files");
        $subdomain = $request->input("subdomain");

        $data['document_type'] = $doc_type;
        $data['folder_id'] = $folder_id;
        $data['case_id'] = $case_id;
        $data['files'] = $files;
        $result = professionalCurl('cases/save-exchange-documents',$subdomain,$data);
        if(isset($result['status']) && $result['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "File transfered successfully";
        }else{
            $response['status'] = false;
            $response['message'] = "Issue in file transfer, try again";
        }
        return response()->json($response); 
    }

    public function myDocumentsExchanger($subdomain,$case_id){

        $data['case_id'] = $case_id;
        $data['client_id'] = \Auth::user()->unique_id;
        $api_response = professionalCurl('cases/documents-exchanger',$subdomain,$data);
       
        if($api_response['status'] == 'error'){
            return redirect(baseUrl('/cases'))->with("error",$api_response['message']);
        }
        $result = $api_response['data'];
        
        if(!isset($api_response['status'])){
            return redirect()->back()->with("success","Some issue while fetching data try again");
        }else{
            if($api_response['status'] != 'success'){
                return redirect()->back()->with("success",$api_response['message']);
            }
        }
        $record = $result['record'];
        $service = $result['service'];
        $documents = $result['documents'];
        $case_folders = $result['case_folders'];
        
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record['id'];
        $viewData['pageTitle'] = "Export from My Documents";

        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        
        $user_file_url = userDirUrl()."/documents";
        $user_file_dir = userDir()."/documents";
        $viewData['user_file_url'] = $user_file_url;
        $viewData['user_file_dir'] = $user_file_dir;
        $viewData['user_folders'] = $user_folders;

        return view(roleFolder().'.cases.my-documents-exchanger',$viewData);
    }

    public function exportMyDocuments(Request $request){
        $doc_type = $request->input("document_type");
        $folder_id = $request->input("folder_id");
        $case_id = $request->input("case_id");
        $files = $request->input("files");
        $subdomain = $request->input("subdomain");
        
        $user_files = FilesManager::select("unique_id","original_name","file_name","user_id")->whereIn("unique_id",$files)->get();
        if(!empty($user_files)){
            $user_files = $user_files->toArray();
        }else{
            $user_files = array();
        }
        $data['document_type'] = $doc_type;
        $data['folder_id'] = $folder_id;
        $data['case_id'] = $case_id;
        $data['files'] = $files;
        $data['user_files'] = $user_files;
        $data['created_by'] = \Auth::user()->unique_id;
        
        $api_response = professionalCurl('cases/exchange-user-documents',$subdomain,$data);
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "File transfered successfully";
        }else{
            $response['status'] = false;
            $response['message'] = "Issue in file transfer, try again";
        }
        return response()->json($response); 
    }

    public function removeCaseDocument(Request $request){
        $doc_type = $request->input("document_type");
        $folder_id = $request->input("folder_id");
        $case_id = $request->input("case_id");
        $file_id = $request->input("file_id");
        $subdomain = $request->input("subdomain");

        $data['document_type'] = $doc_type;
        $data['folder_id'] = $folder_id;
        $data['case_id'] = $case_id;
        $data['file_id'] = $file_id;
        
        $api_response = professionalCurl('cases/remove-case-document',$subdomain,$data);
       
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "File removed successfully";
        }else{
            $response['status'] = false;
            $response['message'] = $api_response['message'];
        }
        return response()->json($response); 
    }

    public function viewDocument($case_id,$doc_id,Request $request){
        $url = $request->get("url");
        $filename = $request->get("file_name");
        $ext = fileExtension($filename);
        $subdomain = $request->get("p");
        $folder_id = $request->get("folder_id");
        
        $doc_type = $request->get("doc_type");
        $viewData['url'] = $url;
        $viewData['doc_type'] = $doc_type;
        $viewData['extension'] = $ext;
        $viewData['subdomain'] = $subdomain;
        $viewData['folder_id'] = $folder_id;
        $viewData['case_id'] = $case_id;
        $viewData['document_id'] = $doc_id;
        $viewData['pageTitle'] = "View Documents";
        return view(roleFolder().'.cases.view-documents',$viewData);
    }

    public function fileMoveTo($subdomain,$id,$case_id,$doc_id){
        $id = base64_decode($id);
        $case_id = base64_decode($case_id);
        $doc_id = base64_decode($doc_id);
        $case = Cases::find($case_id);

        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        $result = $api_response['data'];

        $documents = ServiceDocuments::where("service_id",$case->visa_service_id)->get();
        $document = ServiceDocuments::where("id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("id",$case->visa_service_id)->first();
        
        $case_folders = CaseFolders::where("case_id",$case->id)->get();
        $viewData['service'] = $service;
        $viewData['case'] = $case;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['document'] = $document;
        $record = CaseDocuments::find($id);
        $viewData['id'] = $id;
        $viewData['pageTitle'] = "Move File";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.cases.modal.move-to',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function deleteDocument($subdomain,$id){
        $data = array();
        $data['document_id'] = $id;   

        $api_response = professionalCurl('cases/case-document-detail',$subdomain,$data);
        $result = $api_response['data'];
        $document = $result['record'];
       
        $data = array();
        $data['document_type'] = $document['document_type'];
        $data['folder_id'] = $document['folder_id'];
        $data['case_id'] = $document['case_id'];
        $data['file_id'] = $document['file_id'];
        
        $api_response = professionalCurl('cases/remove-case-document',$subdomain,$data);
        
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            return redirect()->back()->with("success","File removed successfully");
        }else{
            return redirect()->back()->with("error","Issue in file removed, try again");
        }
    }
    public function deleteMultipleDocuments(Request $request){
        $ids = explode(",",$request->input("ids"));
        $subdomain = $request->input("subdomain");
       
        
        for($i = 0;$i < count($ids);$i++){
            $data = array();
            $data['document_id'] = $ids[$i]; 
             
            $api_response = professionalCurl('cases/case-document-detail',$subdomain,$data);
            
            $result = $api_response['data'];
            $document = $result['record'];
            $data = array();
            $data['document_type'] = $document['document_type'];
            $data['folder_id'] = $document['folder_id'];
            $data['case_id'] = $document['case_id'];
            $data['file_id'] = $document['file_id'];
            $api_response = professionalCurl('cases/remove-case-document',$subdomain,$data);

        }
        $response['status'] = true;
        \Session::flash('success', 'Documents deleted successfully'); 
        return response()->json($response);
    }

    public function importToMyDocuments($subdomain,$case_id){

        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        $result = $api_response['data'];
        
        

        if(!isset($api_response['status'])){
            return redirect()->back()->with("success","Some issue while fetching data try again");
        }else{
            if($api_response['status'] != 'success'){
                return redirect()->back()->with("success",$api_response['message']);
            }
        }
        $record = $result['record'];
        $service = $result['service'];
        $documents = $result['documents'];
        $case_folders = $result['case_folders'];
     

        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record['id'];
        $viewData['pageTitle'] = "Import from case to My Documents";

        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        
        $user_file_url = userDirUrl()."/documents";
        $user_file_dir = userDir()."/documents";
        $viewData['user_file_url'] = $user_file_url;
        $viewData['user_file_dir'] = $user_file_dir;
        $viewData['user_folders'] = $user_folders;

        return view(roleFolder().'.cases.import-documents',$viewData);
    }

    public function saveImportDocuments(Request $request){

        $folder_id = $request->input("folder_id");
        $subdomain = $request->input("subdomain");
        $files = $request->input("files");
        for($i=0;$i < count($files);$i++){
            $data['document_id'] = $files[$i];
            $api_response = professionalCurl('cases/document-detail',$subdomain,$data);
            
            $result = $api_response['data'];
            $document = $result['record'];
           
            $file_dir = $result['file_dir'];
            $file_check = FilesManager::where("user_id",\Auth::user()->unique_id)
                                    ->where("is_shared",1)
                                    ->where("shared_id",$document['unique_id'])
                                    ->where("shared_from",$subdomain)
                                    ->first();
            $source = $file_dir."/".$document['file_name'];
            $destination = $file_dir."/".$document['file_name'];
            $new_name = randomNumber(5)."-".$document['original_name'];
            $destination = userDir()."/documents/".$new_name;
            if(!empty($file_check)){
                $unique_id = $file_check->unique_id;
            }else{
                copy($source, $destination);
                $unique_id = randomNumber();
                $object = new FilesManager();
                $object->file_name = $new_name;
                $object->original_name = $document['original_name'];
                $ext = pathinfo($document['original_name'], PATHINFO_EXTENSION);
                $object->file_type = $ext;
                $object->user_id = \Auth::user()->unique_id;
                $object->unique_id = $unique_id;
                $object->is_shared = 1;
                $object->shared_id = $document['unique_id'];
                $object->shared_from = $subdomain;
                $object->created_by = \Auth::user()->unique_id;
                $object->save();
            }

            $check_user_file = UserFiles::where("folder_id",$folder_id)->where("file_id",$unique_id)->count();
            if($check_user_file <= 0){
                $object2 = new UserFiles();
                $object2->user_id = \Auth::user()->unique_id;
                $object2->folder_id = $folder_id;
                $object2->file_id = $unique_id;
                $object2->unique_id = randomNumber();
                $object2->save(); 
            }
        }
        $response['status'] = true;
        $response['message'] = "File uploaded!";
        return response()->json($response);
    }

    public function removeUserDocument(Request $request){

        $file_id = $request->input("file_id");
        $folder_id = $request->input("folder_id");
        $file = FilesManager::where("shared_id",$file_id)->first();

        UserFiles::where("file_id",$file->unique_id)->where("folder_id",$folder_id)->delete();

        $check = UserFiles::where("file_id",$file_id)->count();
        
        $dir = userDir()."/documents/".$file->file_name;
        if($check <= 0){
            
            if(file_exists($dir)){
                unlink($dir);
                FilesManager::where("unique_id",$file->unique_id)->delete();
            }
        }

        $response['status'] = true;
        $response['dir'] = $dir;
        $response['message'] = "File removed succcessfully!";
        return response()->json($response);
    }

    public function fetchDocumentChats(Request $request){
        $case_id = $request->input("case_id");
        $document_id = $request->input("document_id");
        $subdomain = $request->input("subdomain");
        $viewData['case_id'] = $case_id;
        $viewData['document_id'] = $document_id;

        $data = array();
        $data['case_id'] = $case_id;
        $data['document_id'] = $document_id;
        $data['type'] = $request->input("type");
        $data['subdomain'] = $subdomain;
        $api_response = professionalCurl('cases/fetch-document-chats',$subdomain,$data);
        $chats = array();
        if($api_response['status'] == 'success'){
            $chats = $api_response['data']['chats'];
        }
        $viewData['chats'] = $chats;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.document-chats',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }

    public function saveDocumentChat(Request $request){
        $subdomain = $request->input("subdomain");
        $data['document_id'] = $request->input("document_id");
        $api_data = professionalCurl('cases/case-document-detail',$subdomain,$data);
        $result = $api_data['data'];
        $document = $result['record'];
        $folder_id = $document['folder_id'];

        $data = array();
        $data['case_id'] = $request->input("case_id");
        $data['document_id'] = $request->input("document_id");
        $data['message'] = $request->input("message");
        $data['created_by'] = \Auth::user()->unique_id;
       
        
        $data['type'] = $request->input("type");
        $api_response = professionalCurl('cases/save-document-chat',$subdomain,$data);
        if($api_response['status'] == 'success'){
            $not_data['send_by'] = 'client';
            $not_data['added_by'] = \Auth::user()->unique_id;
            $not_data['type'] = "chat";
            $not_data['notification_type'] = "document_chat";
            $not_data['title'] = "Message on document by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
            $not_data['comment'] = $request->input("message");
            if($request->input("doc_type") == 'extra'){
                $not_data['url'] = "cases/case-documents/extra/".$request->input("case_id")."/".$folder_id;
            }
            if($request->input("doc_type") == 'other'){
                $not_data['url'] = "cases/case-documents/other/".$request->input("case_id")."/".$folder_id;
            }
            if($request->input("doc_type") == 'default'){
                $not_data['url'] = "cases/case-documents/default/".$request->input("case_id")."/".$folder_id;
            }
            
            $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
            $other_data[] = array("key"=>"document_id","value"=>$request->input("document_id"));

            $not_data['other_data'] = $other_data;
            
            sendNotification($not_data,"professional",$subdomain);
            
            $response['status'] = true;
            $response['message'] = $api_response['message'];
        }else{
            $response['status'] = false;
            $response['message'] = "Message send failed";
        }
        return response()->json($response);
    }

    public function saveDocumentChatFile(Request $request){

        if ($file = $request->file('attachment')){
            $subdomain = $request->input("subdomain");
            $data['document_id'] = $request->input("document_id");
            $api_data = professionalCurl('cases/case-document-detail',$subdomain,$data);
            $result = $api_data['data'];
            $document = $result['record'];
            $folder_id = $document['folder_id'];

            $data = array();
            $data['case_id'] = $request->input("case_id");
            $data['document_id'] = $request->input("document_id");
            
            $fileName  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $newName = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = professionalDir($subdomain)."/documents";
            
            
            if($file->move($destinationPath, $newName)){
                $data['message'] = $fileName;
                $data['created_by'] = \Auth::user()->unique_id;
                $data['original_name'] = $fileName;
                $data['file_name'] = $newName;
                
                $data['type'] = 'file';
                $api_response = professionalCurl('cases/save-document-chat',$subdomain,$data);
                if($api_response['status'] == 'success'){

                    $not_data['send_by'] = 'client';
                    $not_data['added_by'] = \Auth::user()->unique_id;
                    $not_data['type'] = "chat";
                    $not_data['notification_type'] = "document_chat";
                    $not_data['title'] = "Message on document by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
                    $not_data['comment'] = "Document sent by client";
                    if($request->input("doc_type") == 'extra'){
                        $not_data['url'] = "cases/case-documents/extra/".$request->input("case_id")."/".$folder_id;
                    }
                    if($request->input("doc_type") == 'other'){
                        $not_data['url'] = "cases/case-documents/other/".$request->input("case_id")."/".$folder_id;
                    }
                    if($request->input("doc_type") == 'default'){
                        $not_data['url'] = "cases/case-documents/default/".$request->input("case_id")."/".$folder_id;
                    }
                    
                    $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
                    // $other_data[] = array("key"=>"doc_type","value"=>$request->input("doc_type"));
                    $other_data[] = array("key"=>"document_id","value"=>$request->input("document_id"));
                    
                    $not_data['other_data'] = $other_data;
                    
                    sendNotification($not_data,"professional",$subdomain);
                    
                    $response['status'] = true;
                    $response['message'] = $api_response['message'];
                }else{
                    $response['status'] = false;
                    $response['message'] = "File send failed, try again!";
                }                   
            }else{
                $response['status'] = true;
                $response['message'] = "File send failed, try again!";
            }
        }else{
            $response['status'] = false;
            $response['message'] = "File not selected!";
        }
        
        return response()->json($response);
    }

    public function chats($subdomain,$case_id,Request $request){
        $data['case_id'] = $case_id;
        $data['client_id'] = \Auth::user()->unique_id;
        $api_response = professionalCurl('cases/view',$subdomain,$data);
        if($api_response['status'] == 'error'){
            return redirect(baseUrl('/cases'))->with("error",$api_response['message']);
        }
        $case = $api_response['data'];

        if($request->get("type")){
            $chat_type = $request->get("type");
            $sub_title = $case['case_title'];
        }else{
            $chat_type = 'general';
            $sub_title = "General Chats";
        }
        $data = array();
        $data['case_id'] = $case_id;
        $data['user_id'] = \Auth::user()->unique_id;
        $api_response = professionalCurl('cases/chats',$subdomain,$data);
       
        $unread_case_chat = $api_response['unread_case_chat'];
        $unread_general_chat = $api_response['unread_general_chat'];

        $viewData['chat_type'] = $chat_type;
        $viewData['unread_case_chat'] = $unread_case_chat;
        $viewData['unread_general_chat'] = $unread_general_chat;
        $viewData['sub_title'] = $sub_title;
        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/fetch-case-documents',$subdomain,$data);
        if(isset($api_response['data'])){
            $documents = $api_response['data'];
        }else{
            $documents = array();
        }

        if(!isset($api_response['status'])){
            return redirect()->back()->with("success","Some issue while fetching data try again");
        }else{
            if($api_response['status'] != 'success'){
                return redirect()->back()->with("success",$api_response['message']);
            }
        }
        
        $viewData['documents'] = $documents;
        $viewData['case'] = $case;
        $viewData['pageTitle'] = "Chats";
        $viewData['case_id'] = $case_id;
        $viewData['subdomain'] = $subdomain;
        return view(roleFolder().'.cases.chats',$viewData);
    }

    public function fetchChats(Request $request){
        $case_id = $request->input("case_id");
        $chat_type = $request->input("chat_type");
        $subdomain = $request->input("subdomain");
        $viewData['case_id'] = $case_id;
        $viewData['chat_type'] = $chat_type;

        $data = array();
        if($request->input("chat_type") == 'case_chat'){
            $data['case_id'] = $case_id;
        }
        $data['client_id'] = \Auth::user()->unique_id;
        $data['case_id'] = $case_id;
        $data['chat_type'] = $chat_type;
        $data['subdomain'] = $subdomain;
        $api_response = professionalCurl('cases/fetch-chats',$subdomain,$data);
        $chats = array();
        if($api_response['status'] == 'success'){
            $chats = $api_response['data']['chats'];
        }
        $viewData['chats'] = $chats;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.chat-list',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }

    public function saveChat(Request $request){
        $data['case_id'] = $request->input("case_id");
        $data['chat_type'] = $request->input("chat_type");
        $data['message'] = $request->input("message");
        $data['type'] = "text";
        $data['client_id'] = \Auth::user()->unique_id;
        $subdomain = $request->input("subdomain");


        $api_response = professionalCurl('cases/save-chat',$subdomain,$data);
        if($api_response['status'] == 'success'){
            $not_data['send_by'] = 'client';
            $not_data['added_by'] = \Auth::user()->unique_id;
            $not_data['type'] = "chat";
            $not_data['notification_type'] = "case_chat";
            $not_data['title'] = "Message by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
            $not_data['comment'] = $request->input("message");
            if($request->input("chat_type") == 'general'){
                $not_data['notification_type'] = "general";
                $not_data['url'] = "cases/chats/".$request->input("case_id");
            }else{
                $not_data['notification_type'] = "case_chat";
                $not_data['url'] = "cases/chats/".$request->input("case_id")."?chat_type=case_chat";
            }
            
            $other_data[] = array("key"=>"chat_type","value"=>$request->input("chat_type"));
            if($request->input("chat_type") == 'case_chat'){
                $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
            }
            $not_data['other_data'] = $other_data;
            
            sendNotification($not_data,"professional",$subdomain);
            
            $response['status'] = true;
            $response['message'] = $api_response['message'];
        }else{
            $response['status'] = false;
            $response['message'] = "Message send failed";
        }
        return response()->json($response);
    }

    public function saveChatFile(Request $request){

        if ($file = $request->file('attachment')){
            $data['case_id'] = $request->input("case_id");
            $subdomain = $request->input("subdomain");
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = professionalDir($subdomain)."/documents";
            
            
            if($file->move($destinationPath, $newName)){
                $data['message'] = $fileName;
                $data['client_id'] = \Auth::user()->unique_id;
                $data['original_name'] = $fileName;
                $data['file_name'] = $newName;
                $data['chat_type'] = $request->input("chat_type");
                $data['type'] = 'file';
                $api_response = professionalCurl('cases/save-chat',$subdomain,$data);
                if($api_response['status'] == 'success'){
                    $not_data['send_by'] = 'client';
                    $not_data['added_by'] = \Auth::user()->unique_id;
                    $not_data['type'] = "chat";
                    $not_data['notification_type'] = "case_chat";
                    $not_data['title'] = "Message by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
                    $not_data['comment'] = "Document sent in chat";
                    if($request->input("chat_type") == 'general'){
                        $not_data['url'] = "cases/chats/".$request->input("case_id");
                    }else{
                        $not_data['url'] = "cases/chats/".$request->input("case_id")."?chat_type=case_chat";
                    }
                    $other_data[] = array("key"=>"chat_type","value"=>$request->input("chat_type"));
                    if($request->input("chat_type") == 'case_chat'){
                        $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
                    }
                    $not_data['other_data'] = $other_data;                   
                    sendNotification($not_data,"professional",$subdomain);
                    
                    $response['status'] = true;
                    $response['message'] = $api_response['message'];
                }else{
                    $response['status'] = false;
                    $response['message'] = "File send failed, try again!";
                }                   
            }else{
                $response['status'] = false;
                $response['message'] = "File send failed, try again!";
            }
        }else{
            $response['status'] = false;
            $response['message'] = "File not selected!";
        }
        
        return response()->json($response);
    }

    public function chatdemo(){
        $viewData['pageTitle'] = "Chats";
        return view(roleFolder().'.cases.chat-demo',$viewData);
    }

    public function allInvoices()
    {   
        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)->get();
        
        $invoices = array();
        foreach($professionals as $professional){
            $data['client_id'] = \Auth::user()->unique_id;
            $subdomain = $professional->professional;
            $data['invoice_type'] = 'all';
            // pre($data);
            $api_response = professionalCurl('cases/fetch-case-invoices',$subdomain,$data);
            
            if($api_response['status'] == 'success'){
                $records = $api_response['data']['records'];
                foreach($records as $record){
                    unset($record['id']);
                    $temp = $record;
                    $temp['professional'] = $subdomain;
                    $invoices[] = $temp;
                }
            }
        }
        $viewData['records'] = $invoices;
        $viewData['pageTitle'] = "All Invoices";
        return view(roleFolder().'.cases.all-invoices',$viewData);
    } 

    public function caseInvoices($subdomain,$case_id)
    {  
        $data['case_id'] = $case_id;
        $data['client_id'] = \Auth::user()->unique_id;
        $api_response = professionalCurl('cases/view',$subdomain,$data);
        $case = $api_response['data'];
        $viewData['case'] = $case;
        $viewData['pageTitle'] = "Case Invoices";
        $viewData['subdomain'] = $subdomain;
        return view(roleFolder().'.cases.invoices',$viewData);
    } 

    public function getCaseInvoice($subdomain,Request $request)
    {
        $data = $request->input();
        $data['invoice_type'] = 'cases';
        $api_response = professionalCurl('cases/fetch-case-invoices',$subdomain,$data);

        if($api_response['status'] != 'success'){
            $response['status'] = "error";
            $response['message'] = "Issue while finding invoice";
            return response()->json($response);
        }
        $data = $api_response['data'];
        $viewData['records'] = $data['records'];
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.invoices-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $data['last_page'];
        $response['current_page'] = $data['current_page'];
        $response['total_records'] = $data['total_records'];
        return response()->json($response);
    }

    public function viewCaseInvoice($subdomain,$invoice_id){

        $data['invoice_id'] = $invoice_id;
        $api_response = professionalCurl('cases/view-case-invoice',$subdomain,$data);

        if($api_response['status'] != 'success'){
            $response['status'] = "error";
            return redirect()->back()->with("error","Issue while finding invoice");
        }
        $data = $api_response['data'];
        $id = base64_decode($invoice_id);
        $invoice = $data['invoice'];
        $case = $data['case'];
        $client = $data['client'];
        if($client['unique_id'] != \Auth::user()->unique_id){
            return redirect(baseUrl('/'));
        }
        $professional = $data['professional'];
        $viewData['professional'] = $professional;
        $viewData['case'] = $case;
        $viewData['client'] = $client;
        $viewData['record'] = $invoice;
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "View Invoice";
        return view(roleFolder().'.cases.view-invoice',$viewData);
    }

    public function payNow(Request $request){
        $viewData['pageTitle'] = "Pay Now";
        return view(roleFolder().'.pay-now',$viewData);   
    }

    public function professionalProfile($subdomain){
        $data['subdomain'] = $subdomain;
        $api_data = professionalCurl('information',$subdomain,$data);
        if(isset($api_data['status']) && $api_data['status'] == 'success'){
            $data = $api_data['data'];
            $company = $data['company'];
            $admin = $data['admin'];
            $services = $data['services'];
        }else{
            return redirect()->back()->with("error","Professional profile not found");
        }
        //print_r($company);
        //print_r($admin);
        //exit;
        $viewData['services'] = $services;
        $viewData['company'] = $company;
        $viewData['admin'] = $admin;
        return view(roleFolder().'.cases.professional-profile',$viewData);
    }
    public function fetchGoogleDrive($folder_id,Request $request){
        $doc_type = $request->input("doc_type");
        $subdomain = $request->input("subdomain");
        $case_id = $request->input("case_id");

        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
        $drive = create_crm_gservice($google_drive_auth['access_token']);
        $drive_folders = get_gdrive_folder($drive);
        if(isset($drive_folders['gdrive_files'])){
            $drive_folders = $drive_folders['gdrive_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['pageTitle'] = "Google Drive Folders";
        $viewData['drive_folders'] = $drive_folders;
        $viewData['folder_id'] = $folder_id;
        $viewData['case_id'] = $case_id;
        $viewData['doc_type'] = $doc_type;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.modal.google-drive',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);  
    }
    public function googleDriveFilesList(Request $request){
        $folder_id = $request->input("folder_id");
        $folder = $request->input("folder_name");
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
        $drive = create_crm_gservice($google_drive_auth['access_token']);
        $drive_folders = get_gdrive_folder($drive,$folder_id,$folder);
        if(isset($drive_folders['gdrive_files'])){
            $drive_folders = $drive_folders['gdrive_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['drive_folders'] = $drive_folders;
        $view = View::make(roleFolder().'.cases.modal.google-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function uploadFromGdrive(Request $request){

        if($request->input("files")){
            $files = $request->input("files");
            $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
            $access_token = $google_drive_auth['access_token'];
            $folder_id = $request->input("folder_id");
            $doc_type = $request->input("doc_type");
            $subdomain = $request->input("subdomain");
            $case_id = $request->input("case_id");
            foreach($files as $key => $fileId){
                $i = $key;
                $ch = curl_init();
                $method = "GET";
                // get file type
                $endpoint = 'https://www.googleapis.com/drive/v3/files/'.$fileId;
                curl_setopt($ch, CURLOPT_URL,$endpoint);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$access_token['access_token']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $curl_response = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                $file = json_decode($curl_response,true);
                // get file base64 format
                $ch = curl_init();
                $endpoint = 'https://www.googleapis.com/drive/v3/files/'.$fileId.'?alt=media';
                curl_setopt($ch, CURLOPT_URL,$endpoint);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$access_token['access_token']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $api_response = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                $base64_code = $api_response;
                $original_name = $file['name'];
                
                $newName = time()."-".$original_name;
                $path = professionalDir($subdomain)."/documents";
                if(file_put_contents($path."/".$newName, $base64_code)){
                    $insData['newName'] = $newName;
                    $insData['case_id'] = $case_id;
                    $insData['original_name'] = $original_name;
                    $insData['created_by'] = \Auth::user()->unique_id;
                    $insData['document_type'] = $doc_type;
                    $insData['folder_id'] = $folder_id;
                   
                    $api_response = professionalCurl('cases/upload-documents',$subdomain,$insData);
                    
                    if($api_response['status'] == 'success'){
                        $response['status'] = true;
                        $response['message'] = 'File uploaded from google drive successfully!';
                    }else{
                        $response['status'] = false;
                        $response['message'] = 'File not uploaded!';
                    }
                }
            }
        }else{
            $response['status'] = false;
            $response['error_type'] = 'no_files';
            $response['message'] = "No Files selected";
        }
        return response()->json($response);
    }
    public function fetchDropboxFolder($folder_id,Request $request){
        $doc_type = $request->input("doc_type");
        $subdomain = $request->input("subdomain");
        $case_id = $request->input("case_id");
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
        $drive_folders = dropbox_files_list($dropbox_auth);
        
        if(isset($drive_folders['dropbox_files'])){
            $drive_folders = $drive_folders['dropbox_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['pageTitle'] = "Dropbox Folders";
        $viewData['drive_folders'] = $drive_folders;
        $viewData['folder_id'] = $folder_id;
        $viewData['case_id'] = $case_id;
        $viewData['doc_type'] = $doc_type;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.modal.dropbox-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);  
    }

    public function dropboxFilesList(Request $request){
        $folder_id = $request->input("folder_id");
        $folder = $request->input("folder_name");
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
        $drive_folders = dropbox_files_list($dropbox_auth,$folder_id);
        
        if(isset($drive_folders['dropbox_files'])){
            $drive_folders = $drive_folders['dropbox_files'];
        }else{
            $drive_folders = array();
        }
        // pre($drive_folders);
        $viewData['drive_folders'] = $drive_folders;
        $view = View::make(roleFolder().'.cases.modal.dropbox-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function uploadFromDropbox(Request $request){
        
        if($request->input("files")){
            $files = $request->input("files");
            $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
            $folder_id = $request->input("folder_id");
            $doc_type = $request->input("doc_type");
            $subdomain = $request->input("subdomain");
            $case_id = $request->input("case_id");
            foreach($files as $key => $fileId){
                $i = $key;
                $fileinfo = explode(":::",$fileId);
                $original_name = $fileinfo[1];
                $file_path = $fileinfo[0];
                $newName = time()."-".$original_name;
                
                $path = professionalDir($subdomain)."/documents";
                $destinationPath = $path."/".$newName;
                
                $is_download = dropbox_file_download($dropbox_auth,$file_path,$destinationPath);

                if(file_exists($destinationPath)){
                    $insData['newName'] = $newName;
                    $insData['case_id'] = $case_id;
                    $insData['original_name'] = $original_name;
                    $insData['created_by'] = \Auth::user()->unique_id;
                    $insData['document_type'] = $doc_type;
                    $insData['folder_id'] = $folder_id;
                   
                    $api_response = professionalCurl('cases/upload-documents',$subdomain,$insData);
                    
                    if($api_response['status'] == 'success'){
                        $response['status'] = true;
                        $response['message'] = 'File uploaded from dropbox successfully!';
                    }else{
                        $response['status'] = false;
                        $response['message'] = 'File not uploaded!';
                    }
                }
            }
        }else{
            $response['status'] = false;
            $response['error_type'] = 'no_files';
            $response['message'] = "No Files selected";
        }
        return response()->json($response);
    }

    public function allTasks()
    {   
        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)->get();
        
        $invoices = array();
        foreach($professionals as $professional){
            $data['client_id'] = \Auth::user()->unique_id;
            $subdomain = $professional->professional;
            $data['task_type'] = 'all';
            $data['task_status'] = 'pending';
            $api_response = professionalCurl('cases/fetch-case-tasks',$subdomain,$data);
            
            if($api_response['status'] == 'success'){
                $records = $api_response['data']['records'];
                foreach($records as $record){
                    unset($record['id']);
                    $temp = $record;
                    $temp['professional'] = $subdomain;
                    $invoices[] = $temp;
                }
            }
        }
        $viewData['records'] = $invoices;
        $viewData['pageTitle'] = "All Tasks";
        return view(roleFolder().'.cases.all-tasks',$viewData);
    } 

    public function viewCaseTask($subdomain,$task_id){

        $data['task_id'] = $task_id;
        $api_response = professionalCurl('cases/view-case-task',$subdomain,$data);
        if($api_response['status'] != 'success'){
            $response['status'] = "error";
            return redirect()->back()->with("error","Issue while finding invoice");
        }
        $record = $api_response['record'];
        if($record['client_id'] != \Auth::user()->unique_id){
            return redirect(baseUrl('/'));
        }
        $professional = $api_response['professional'];
        $viewData['professional'] = $professional;
        $viewData['record'] = $record;
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "View Task";
        $viewData['task_id'] = $task_id;
        return view(roleFolder().'.cases.view-task',$viewData);
    }

    public function sendTaskComment(Request $request){
        $subdomain = $request->input("subdomain");
        $task_id =  $request->input("task_id");
        $data['task_id'] = $task_id;
        $data['send_by'] = \Auth::user()->unique_id;
        $data['unique_id'] = randomNumber();
        $data['user_type'] = "user";
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        if($request->input("message")){
            $data['message'] = $request->input("message");
        }
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        = randomNumber(5)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = professionalDir($subdomain)."/cases/tasks";
                if($file->move($destinationPath, $newName)){
                    $data['file_name'] = $newName;
                }
            }else{
                $response['status'] = false;
                $response['message'] = "File not allowed";
                return response()->json($response);
            } 
        }

        DB::table(PROFESSIONAL_DATABASE.$subdomain.".case_task_comments")->insert($data);

        $response['status'] = true;
        $response['message'] = "Task comment added successfully";
        return response()->json($response);
    }

    public function fetchTaskComments($subdomain,$task_id, Request $request){
        // $task_id = $request->input("task_id");
        // $subdomain = $request->input("subdomain");

        $comments = DB::table(PROFESSIONAL_DATABASE.$subdomain.".case_task_comments")->where('task_id',$task_id)->get();
        $viewData['comments'] = $comments;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.task-comments',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }
    public function removeCaseFolder($subdomain,$id,Request $request){
        $data['folder_id'] = $id;
        $apiData = professionalCurl('cases/remove-case-folder',$subdomain,$data);
        if($apiData['status'] == 'success'){
            return redirect()->back()->with("success",'Folder removed successfully');
        }else{
            return redirect()->back()->with("error",'Error while removing folder');
        }
    }
    public function copyFolderToExtra(Request $request){
        $subdomain = $request->input("subdomain");
        $case_id = $request->input("case_id");
        $folder_ids = $request->input("folder_ids");
        
        $data = array();
        $data['case_id'] = $case_id;
        $data['folder_ids'] = $folder_ids;
        $data['client_id'] = \Auth::user()->unique_id;
       
        $case_view = professionalCurl('cases/copy-folder-to-case',$subdomain,$data);
        
        if(isset($case_view['status']) && $case_view['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = $case_view['message'];
        }else{
            $response['status'] = false;
            $response['message'] = $case_view['message'];
        }
        return response()->json($response);
    }

    public function moveToProfessional($case_id,$folder_id,$subdomain){
        $data['case_id'] = $case_id;
        $case = professionalCurl('cases/documents',$subdomain,$data);
  
        $record = array();
        $service = array();
        $case_folders = array();
        $documents = array();
       
        if(isset($case['status']) && $case['status'] == 'success'){
            $case_data = $case['data'];
            $service = $case_data['service'];
            $case_folders = $case_data['case_folders'];
            $documents = $case_data['documents'];
        }
        $viewData['pageTitle'] = "Move files to Professional";
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['service'] = $service;
        $viewData['case_id'] = $case_id;
        $viewData['folder_id'] = $folder_id;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.modal.move-to-professional',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);    
    }

    public function copyToProfessional($case_id,$user_folder_id,$subdomain,Request $request){
        $file_ids = $request->input("file_ids");
        $folder_id = $request->input("folder_id");
        $data = array();
        $data['case_id'] = $case_id;
        $data['file_ids'] = $file_ids;
        $data['user_folder_id'] = $user_folder_id;
        $data['folder_id'] = $folder_id;
        $data['file_ids'] = $file_ids;
        $data['client_id'] = \Auth::user()->unique_id;
     
        $apiData = professionalCurl('cases/copy-to-professional',$subdomain,$data);
        
        if(isset($apiData['status']) && $apiData['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = $apiData['message'];
        }else{
            $response['status'] = false;
            $response['message'] = $apiData['message'];
        }
        return response()->json($response); 
    }

    public function previewDocument($case_id,$doc_id,Request $request){
        $url = $request->get("url");
        $filename = $request->get("file_name");
        $extension = fileExtension($filename);
        $subdomain = $request->get("p");
        $folder_id = $request->get("folder_id");
        
        $doc_type = $request->get("doc_type");
        $document = '';
        if($extension == 'image'){
            $document = '<div class="text-center"><img src="'.$url.'" class="img-fluid" /></div>';
        }else{
            if(google_doc_viewer($extension)){
                $document = '<iframe src="http://docs.google.com/viewer?url='.$url.'&embedded=true" style="margin:0 auto; width:100%; height:700px;" frameborder="0"></iframe>';
            }else{
                $document = '<iframe src="'.$url.'" style="margin:0 auto; width:100%; height:700px;" frameborder="0"></iframe>';
            }
        }
        $response['status'] = true;
        $response['content'] = $document;
        return response()->json($response);
    }

}
