<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFiles extends Model
{
    use HasFactory;
    protected $table = "user_files";

    static function deleteRecord($id){
        UserFiles::where("id",$id)->delete();
    }
    
    public function FileDetail()
    {
        return $this->belongsTo('App\Models\FilesManager','file_id','unique_id');
    }
}
