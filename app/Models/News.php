<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalServices;

class News extends Model
{
    use HasFactory;
    protected $table = "news";

    public function fetchNewsCategory(){
        return $this->belongsTo('App\Models\VisaServices','category_id');
    }

    public function fetchUser(){
        return $this->belongsTo('App\Models\User','added_by');
    }

    static function deleteRecord($id){
        News::where("id",$id)->delete();
    }
}
