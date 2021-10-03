<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Tags extends Model
{
    use HasFactory;
    protected $table = "tags";

 	public function fetchUser(){
        return $this->belongsTo('App\Models\User','added_by');
    }

    static function deleteRecord($id){
        Tags::where("id",$id)->delete();
    }
}
