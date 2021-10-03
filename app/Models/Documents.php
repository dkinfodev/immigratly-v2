<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CaseDocuments;
class Documents extends Model
{
    use HasFactory;

    static function deleteRecord($id){
    	$record = Documents::where("id",$id)->first();
        Documents::where("id",$id)->delete();
        $file_name = $record->file_name;
        if($file_name != '' && file_exists(professionalDir()."/documents/".$file_name)){
			unlink(professionalDir()."/documents/".$file_name);        	
        }
    }

    static function searchUnlinkFiles(){
    	$files = Documents::get();
    	$unlinkFiles = array();
    	foreach($files as $file){
    		$is_linked = 0;
	    	$files = CaseDocuments::where("file_id",$id)->count();
	    	if($files > 0){
	    		$is_linked = 1;
	    	}

	    	if($is_linked == 0){
	    		$unlinkFiles[] = $file;
	    	}
    	}

    	return $unlinkFiles;
    }	

}
