<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\FilesManager;
use App\Models\UserFolders;
use App\Models\UserFiles;
use App\Models\UserDocumentNotes;

class MyDocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    public function myFolders()
    {
       	$viewData['pageTitle'] = "My Documents";
        $viewData['activeTab'] = "documents";
        $user_folders = UserFolders::where("user_id",\Auth::user()->unique_id)->get();
        $viewData['user_folders'] = $user_folders;
        return view(roleFolder().'.documents.folders',$viewData);
    }
    public function addFolder(Request $request){
        $viewData['pageTitle'] = "Add Folder";
        $viewData['activeTab'] = "documents";
        $view = View::make(roleFolder().'.documents.modal.add-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function createFolder(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
        $name_exists = 0;
        $counter = 1;
        $folder_name = $request->input("name");
        
        
        $object = new UserFolders();
        $object->user_id = \Auth::user()->unique_id;
        $object->name = $folder_name;
        $object->slug = str_slug($request->input("name"));
        $object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder added successfully";
        
        return response()->json($response);
    }

    public function editFolder($id,Request $request){
        $id = base64_decode($id);
        $record = UserFolders::find($id);
        $viewData['activeTab'] = "documents";
        $viewData['pageTitle'] = "Edit Folder";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.documents.modal.edit-folder',$viewData);
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
        $object = UserFolders::find($id);
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder edited successfully";
        
        return response()->json($response);
    }

    public function deleteFolder($id){
        $id = base64_decode($id);
        UserFolders::deleteRecord($id);
        return redirect()->back()->with("success","Folder has been deleted!");
    }

    public function folderFiles($id){

        $user_id = \Auth::user()->unique_id;
        $document = UserFolders::where("unique_id",$id)->first();

        // $file_managers = FilesManager::get();
       
        $user_documents = UserFiles::with('FileDetail')
                                    ->where("folder_id",$id)
                                    ->where("user_id",$user_id)
                                    ->orderBy("id","desc")
                                    ->get();
        $extensions = array();
        foreach($user_documents as $doc){
            if(!in_array($doc->FileDetail->file_type,$extensions)){
                $extensions[] = $doc->FileDetail->file_type;
            }
        }
        
        $user_id = \Auth::user()->unique_id;
        $viewData['user_documents'] = $user_documents;
        $user_detail = UserDetails::where("user_id",$user_id)->first();
        $viewData['user_detail'] = $user_detail;
        $viewData['user_documents'] = $user_documents;
        $viewData['pageTitle'] = "Files List for ".$document->name;
        $viewData['extensions'] = $extensions;
 
        $file_url = userDirUrl()."/documents";
        $file_dir = userDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['document'] = $document;
        $ext_files = implode(",",allowed_extension());
        $viewData['ext_files'] = $ext_files;
        return view(roleFolder().'.documents.files',$viewData);
    }

    // public function folderFilesAjax(Request $request){
    //     $folder_id = $request->input("folder_id");
    //     $search = $request->input("search");
    //     $file_type = $request->input("file_type");
    //     $sort_by = $request->input("sort_by");
       
    //     $document = UserFolders::where("unique_id",$folder_id)->first();
    //     $user_id = \Auth::user()->unique_id;
    //     $column = "files_manager.id";
    //     $order = "desc";
    //     if($sort_by != ''){
    //         switch($sort_by){
    //             case "added_by_asc":
    //                 $column = "files_manager.created_at";
    //                 $order = "asc";
    //                 break;
    //             case "added_by_desc":
    //                 $column = "files_manager.created_at";
    //                 $order = "desc";
    //                 break;
    //             case "name_asc":
    //                 $column = "files_manager.original_name";
    //                 $order = "asc";
    //                 break;
    //             case "name_desc":
    //                 $column = "files_manager.original_name";
    //                 $order = "desc";
    //                 break;
    //             default:
    //                 $column = "files_manager.id";
    //                 $order = "desc";
    //                 break;

    //         }
    //     }
    //     $user_documents = UserFiles::with('FileDetail')
    //                                 ->join('files_manager', 'files_manager.unique_id', '=', 'user_files.file_id')
    //                                 ->where(function ($query) use ($file_type) {
    //                                     if($file_type != ''){
    //                                         $query->where("files_manager.file_type",$file_type);
    //                                     }
    //                                 })
    //                                 ->where("user_files.folder_id",$folder_id)
    //                                 ->where("user_files.user_id",$user_id)
    //                                 ->select("user_files.*")
    //                                 ->orderBy($column,$order)
    //                                 ->get();
       
    //     $viewData['user_documents'] = $user_documents;
    //     $file_url = userDirUrl()."/documents";
    //     $file_dir = userDir()."/documents";
    //     $viewData['file_url'] = $file_url;
    //     $viewData['file_dir'] = $file_dir;
    //     $viewData['document'] = $document;
        
    //     $view = View::make(roleFolder().'.documents.files-ajax',$viewData);
    //     $contents = $view->render();
    //     $response['contents'] = $contents;
    //     $response['status'] = true;
    //     return response()->json($response);        
    // }

    public function uploadDocuments(Request $request){
        try{
            $id = \Auth::user()->unique_id;
            $folder_id = $request->input("folder_id");
            $failed_files = array();
            if($file = $request->file('file'))
            {
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension();
                $allowed_extension = allowed_extension();
                if(in_array($extension,$allowed_extension)){
                    $newName        = randomNumber(5)."-".$fileName;
                    $source_url = $file->getPathName();
                    $destinationPath = userDir()."/documents";
                    if($file->move($destinationPath, $newName)){
                        $unique_id = randomNumber();
                        $check_file_name = FilesManager::where("created_by",\Auth::user()->unique_id)->count();
                        if(!empty($check_file_name)){
                            $filname_without_ext = pathinfo($fileName, PATHINFO_FILENAME);
                            $fileName = $filname_without_ext."(".$check_file_name.").".$extension;
                        }
                        $object = new FilesManager();
                        $object->file_name = $newName;
                        $object->original_name = $fileName;
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        $object->file_type = $ext;
                        $object->user_id = $id;
                        $object->unique_id = $unique_id;
                        $object->created_by = \Auth::user()->unique_id;
                        $object->save();

                        $object2 = new UserFiles();
                        $object2->user_id = $id;
                        $object2->folder_id = $folder_id;
                        $object2->file_id = $unique_id;
                        $object2->unique_id = randomNumber();
                        $object2->save();
                        $response['status'] = true;
                        $response['message'] = 'File uploaded!';
                    }else{
                        $response['status'] = false;
                        $response['message'] = 'File not uploaded!';
                    }
                }else{
                    $response['status'] = false;
                    $response['message'] = "File not allowed";
                } 
            }else{
                $response['status'] = false;
                $response['message'] = 'Please select the file';
            }
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fileMoveTo($id){
        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        $record = UserFiles::where("unique_id",$id)->first();
        $viewData['user_folders'] = $user_folders;

        $viewData['id'] = $id;
        $viewData['move_type'] = 'single';
        $viewData['pageTitle'] = "Move File";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.documents.modal.move-to',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function moveFileToFolder(Request $request){
        $id = $request->input("id");
        $folder_id = $request->input("folder_id");
        $data['folder_id'] = $folder_id;
        UserFiles::where("unique_id",$id)->update($data);

        $response['status'] = true;
        $response['message'] = "File moved to folder successfully";
        \Session::flash('success', 'File moved to folder successfully'); 
        return response()->json($response);       
    }

    public function moveFiles($folder_id){
        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        $folder = UserFolders::where("unique_id",$folder_id)->first();
        $viewData['folder'] = $folder;
        $viewData['user_folders'] = $user_folders;
        $viewData['move_type'] = 'multiple';
        $viewData['pageTitle'] = "Move File";
        $view = View::make(roleFolder().'.documents.modal.move-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function moveMultipleFiles(Request $request){
        $ids = $request->input("ids");
        $folder_id = $request->input("folder_id");
        $ids = explode(",",$ids);
     
        for($i = 0;$i < count($ids);$i++){
            $data['folder_id'] = $folder_id;
            UserFiles::where("unique_id",$ids[$i])->update($data);
        }

        $response['status'] = true;
        $response['message'] = "Files moved to folder successfully";
        \Session::flash('success', 'File moved to folder successfully'); 
        return response()->json($response);       
    }

    public function documentsExchanger(){
        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        
        $file_url = userDirUrl()."/documents";
        $file_dir = userDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['user_folders'] = $user_folders;
        $viewData['pageTitle'] = "Documents Exchanger";
        $viewData['activeTab'] = "documents";
        return view(roleFolder().'.documents.documents-exchanger',$viewData);
    }

    public function saveExchangeDocuments(Request $request){
        $folder_id = $request->input("folder_id");
        $user_id = \Auth::user()->unique_id;
        $files = $request->input("files");
        $existing_files = UserFiles::where("user_id",$user_id)
                        ->where("folder_id",$folder_id)
                        ->pluck("file_id");
        
        if(!empty($existing_files)){
            $existing_files = $existing_files->toArray();
            $new_files = array_diff($files,$existing_files);
            $new_files = array_values($new_files);
        }else{
            $new_files = $files;
        }
        for($i=0;$i < count($new_files);$i++){
            $data = array();
            $data['folder_id'] = $folder_id;
            UserFiles::where("file_id",$new_files[$i])->update($data);
        }

        $response['status'] = true;
        $response['message'] = "File transfered successfully";
        return response()->json($response); 
    }

    public function viewDocument($file_id,Request $request){
                
        // $url = $request->get("url");
        // $filename = $request->get("file_name");
        // $folder_id = $request->get("folder_id");
        // $ext = fileExtension($filename);
        // $subdomain = $request->get("p");
        // $user_file = UserFiles::with('FileDetail')
        //             ->where("unique_id",$file_id)
        //             ->where("user_id",\Auth::user()->unique_id)
        //             ->first();
    
        // if(empty($user_file)){
        //     return redirect(baseUrl('/documents'))->with("error","Invaild file access");
        // }
        // $viewData['url'] = $url;
        // $viewData['extension'] = $ext;
        // $viewData['document_id'] = $file_id;
        // $viewData['folder_id'] = $folder_id;
        // $viewData['user_file'] = $user_file;
        // $viewData['pageTitle'] = "View Documents";
        // return view(roleFolder().'.documents.view-documents',$viewData);

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

    public function renameFile($id,Request $request){
        
        $data['document_id'] = $id;
        $viewData['document_id'] = $id;
        $viewData['pageTitle'] = "Rename File";
        //$viewData['record'] = $record;
        $view = View::make(roleFolder().'.documents.modal.rename-file',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function updateFilename($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $response['error_type'] = 'validation';
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        
        //
        $uid = \Auth::user()->unique_id;
        $current_file = UserFiles::where("file_id",$id)->first();
        $exOb = FilesManager::where("unique_id",$id)->first();

        $ext = $exOb->file_type;
        $file_name = $request->input("name").".".$ext;
        $new_name = $this->checkFileName($file_name);
        $sourceDir = userDir($uid)."/documents/".$exOb->file_name;
        $destinationDir = userDir($uid)."/documents/".$new_name;
        if(rename($sourceDir,$destinationDir)){
            $object = FilesManager::where("unique_id",$id)->first();
            $object->original_name = $new_name;
            $object->file_name = $new_name;
            $object->save();

            $response['status'] = true;
            $response['message'] = "File name renamed";
        }else{
            $response['status'] = false;
            $response['message'] = "Issue whle renaming file";
        }
        //
        
        return response()->json($response); 

    }
    public function deleteDocument($id){
        $id = base64_decode($id);
        UserFiles::deleteRecord($id);
        return redirect()->back()->with("success","Document has been deleted!");
    }
    public function deleteMultipleDocuments(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            UserFiles::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Documents deleted successfully'); 
        return response()->json($response);
    }
    public function fetchGoogleDrive($folder_id,Request $request){

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
        $view = View::make(roleFolder().'.documents.modal.google-drive',$viewData);
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
        $view = View::make(roleFolder().'.documents.modal.google-files',$viewData);
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
                if (!file_exists(userDir())) {
                    mkdir(userDir(), 0777, true);
                }
                $path = userDir()."/documents";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $destinationPath = $path.'/thumb';
                
                if(file_put_contents($path."/".$newName, $base64_code)){
                    $unique_id = randomNumber();
                    $object = new FilesManager();
                    $object->file_name = $newName;
                    $object->original_name = $original_name;
                    $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                    $object->file_type = $ext;
                    $object->user_id = \Auth::user()->unique_id;
                    $object->unique_id = $unique_id;
                    $object->created_by = \Auth::user()->unique_id;
                    $object->save();

                    $object2 = new UserFiles();
                    $object2->user_id = \Auth::user()->unique_id;
                    $object2->folder_id = $folder_id;
                    $object2->file_id = $unique_id;
                    $object2->unique_id = randomNumber();
                    $object2->save();
                }
            }
            $response['status'] = true;
            $response['message'] = 'File uploaded from google drive successfully!';
        }else{
            $response['status'] = false;
            $response['error_type'] = 'no_files';
            $response['message'] = "No Files selected";
        }
        return response()->json($response);
    }

    public function fetchDropboxFolder($folder_id,Request $request){

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
        $view = View::make(roleFolder().'.documents.modal.dropbox-folder',$viewData);
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
        $view = View::make(roleFolder().'.documents.modal.dropbox-files',$viewData);
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
            foreach($files as $key => $fileId){
                $i = $key;
                $fileinfo = explode(":::",$fileId);
                $original_name = $fileinfo[1];
                $file_path = $fileinfo[0];
                $newName = time()."-".$original_name;
                $path = userDir()."/documents";
                $destinationPath = $path."/".$newName;
                
                $is_download = dropbox_file_download($dropbox_auth,$file_path,$destinationPath);

                if(file_exists($destinationPath)){
                    $unique_id = randomNumber();
                    $object = new FilesManager();
                    $object->file_name = $newName;
                    $object->original_name = $original_name;
                    $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                    $object->file_type = $ext;
                    $object->user_id = \Auth::user()->unique_id;
                    $object->unique_id = $unique_id;
                    $object->created_by = \Auth::user()->unique_id;
                    $object->save();

                    $object2 = new UserFiles();
                    $object2->user_id = \Auth::user()->unique_id;
                    $object2->folder_id = $folder_id;
                    $object2->file_id = $unique_id;
                    $object2->unique_id = randomNumber();
                    $object2->save();
                }
            }
            $response['status'] = true;
            $response['message'] = 'File uploaded from google drive successfully!';
        }else{
            $response['status'] = false;
            $response['error_type'] = 'no_files';
            $response['message'] = "No Files selected";
        }
        return response()->json($response);
    }

    public function fetchDocumentNotes(Request $request){
        $file_id = $request->input("file_id");
        $user_id = \Auth::user()->unique_id;
        $notes = UserDocumentNotes::with('FileDetail')->where("file_id",$file_id)->where("user_id",$user_id)->get();

        $viewData['user_id'] = $user_id;
        $viewData['file_id'] = $file_id;
        $viewData['notes'] = $notes;
        $view = View::make(roleFolder().'.documents.document-notes',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }

    public function saveDocumentNote(Request $request){
        $object = new UserDocumentNotes();
        $object->file_id = $request->input("file_id");
        $object->message = $request->input("message");
        $object->type = $request->input("type");
        $object->user_id = \Auth::user()->unique_id;
        $object->save();
    
        $response['status'] = true;
        $response['message'] = "Note added successfully";

        return response()->json($response);
    }

    public function saveDocumentNoteFile(Request $request){

        if ($file = $request->file('attachment')){
            $data['case_id'] = $request->input("case_id");
            $data['document_id'] = $request->input("document_id");

            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = userDir()."/documents";
            
            
            if($file->move($destinationPath, $newName)){

                $object = new UserDocumentNotes();
                $object->file_id = $request->input("file_id");
                $object->message = $fileName;
                $object->type = 'file';
                $object->user_id = \Auth::user()->unique_id;
                $object->save();
            
                $response['status'] = true;
                $response['message'] = "File send successfully";
               
                
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

    public function checkFileName($filename){
     
        $current_file = FilesManager::where("original_name",$filename)->count();

        if($current_file > 0){
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $original_name = str_replace(".".$ext,"",$filename);
            $count = $current_file+1;
            $new_name = $original_name."(".$count.").".$ext;
            $name = $this->checkFileName($new_name);
            return $name;
        }else{
            return $filename;
        }
    }
}

