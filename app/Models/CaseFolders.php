<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseFolders extends Model
{
    use HasFactory;
    protected $table = "case_folders";

    static function deleteRecord($id){
        CaseFolders::where("id",$id)->delete();
    }
}
