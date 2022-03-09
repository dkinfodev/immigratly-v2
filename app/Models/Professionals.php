<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalReview;

class Professionals extends Model
{
    protected $table = "professionals";

    public function PersonalDetail($subdomain)
    {
        $data = DB::table(PROFESSIONAL_DATABASE.$subdomain.".users")->where("role","admin")->first();
        return $data;
    }

    public function CompanyDetail($subdomain)
    {
        $data = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_details")->first();
        return $data;
    }

    public function getLanguage($id){
        $object = Languages::where("id",$id)->first();
        if(!empty($object)){
            return $object->name;
        }else{
            return '';
        }
    }

    public function getLicenceBodies($id){
        $object = LicenceBodies::where("id",$id)->first();
        if(!empty($object)){
            return $object->name;
        }else{
            return '';
        }
    }

    public function checkReview($id){
        $object = ProfessionalReview::where("professional_id",$id)->get();

        if(!empty($object)){
            return count($object);
        }else{
            return 0;
        }
    }

}
