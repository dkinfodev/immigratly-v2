<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDependents extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        CaseDependents::where("id",$id)->delete();
    }

    static function Dependent($id){
        $dependent = \DB::table(MAIN_DATABASE.".user_dependants")->where("unique_id",$id)->first();
        return $dependent;
    }

    static function VisaServices($id){
        $dependent = \DB::table(MAIN_DATABASE.".user_dependants")->where("unique_id",$id)->first();
        return $dependent;
    }
}
