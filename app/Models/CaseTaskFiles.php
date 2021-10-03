<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseTaskFiles extends Model
{
    use HasFactory;

    protected $table = "case_task_files";

    static function deleteRecord($id){
        CaseTaskFiles::where("id",$id)->delete();
    }

}
