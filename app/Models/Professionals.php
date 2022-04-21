<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Professionals extends Model
{
    protected $table = "professionals";

    static function deleteRecord($id){
        $professional = Professionals::where("id",$id)->first();
        $subdomain = $professional->subdomain;
        $assessments = Assessments::where("professional",$subdomain)->get();
        foreach($assessments as $assessment){
            Assessments::deleteRecord($assessment->id);
        }
        BookedAppointments::where("professional",$subdomain)->delete();
        ExternalAssessments::where("subdomain",$subdomain)->delete();
        ProfessionalReview::where("professional_id",$professional->unique_id)->delete();
        SupportChats::where("subdomain",$subdomain)->delete();
        UserWithProfessional::where("professional",$subdomain)->delete();
        $webinars = Webinar::where("professional",$subdomain)->get();
        foreach($webinars as $webinar){
            Webinar::deleteRecord($webinar->id);
        }
        Professionals::where("id",$id)->delete();
        $databasename = PROFESSIONAL_DATABASE.$subdomain;
        if($_SERVER['SERVER_NAME'] == 'localhost'){
            $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
            $db = DB::select($query, [$databasename]);
        
            if (!empty($db)) {
                $sql = " DROP DATABASE ".$databasename;
                DB::statement($sql);
            }
        }else{
            $response = deleteDatabase($databasename,$subdomain);
        }
    }

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

}
