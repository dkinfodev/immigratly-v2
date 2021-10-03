<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";

 	public function fetchUser(){
        return $this->belongsTo('App\Models\User','added_by');
    }

    static function deleteRecord($id){
        Category::where("id",$id)->delete();
        Articles::where("category_id",$id)->delete();
        Webinar::where("category_id",$id)->delete();
    }
}
