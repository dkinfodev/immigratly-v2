<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFolders extends Model
{
    use HasFactory;
    protected $table = "user_folders";

    static function deleteRecord($id){
        UserFolders::where("id",$id)->delete();
    }

    public function Files()
    {
        return $this->hasMany('App\Models\UserFiles','folder_id','unique_id')->with(['FileDetail']);
    }
}
