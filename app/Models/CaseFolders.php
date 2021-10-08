<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseFolders extends Model
{
    use HasFactory;
    protected $table = "case_folders";

    static function deleteRecord($id){
        $record = CaseFolders::where("id",$id)->first();
        CaseFolders::where("id",$id)->delete();   
        if(!empty($record)){
            CaseDocuments::where("case_id",$record->unique_id)->delete();
        }

    }
}
