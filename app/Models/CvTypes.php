<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvTypes extends Model
{
    use HasFactory;

    protected $table = "cv_types";

    static function deleteRecord($id){
        CvTypes::where("id",$id)->delete();
        VisaServices::where("cv_type",$id)->update(['cv_type'=>0]);
    }

    public function VisaServices()
    {
        return $this->hasMany('App\Models\VisaServices','cv_type');
    }
}
