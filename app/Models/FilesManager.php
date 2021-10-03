<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesManager extends Model
{
    use HasFactory;
    protected $table = 'files_manager';
    
    static function deleteRecord($id){
    	$record = FilesManager::where("id",$id)->first();
        FilesManager::where("id",$id)->delete();
        $file_name = $record->file_name;
        if($file_name != '' && file_exists(userDir()."/documents/".$file_name)){
			unlink(userDir()."/documents/".$file_name);        	
        }
    }

    static function searchUnlinkFiles(){
    	$files = FilesManager::get();
    	$unlinkFiles = array();
    	// foreach($files as $file){
    	// 	$is_linked = 0;
	    // 	$files = CaseDocuments::where("file_id",$id)->count();
	    // 	if($files > 0){
	    // 		$is_linked = 1;
	    // 	}

	    // 	if($is_linked == 0){
	    // 		$unlinkFiles[] = $file;
	    // 	}
    	// }

    	return $unlinkFiles;
    }	

}
