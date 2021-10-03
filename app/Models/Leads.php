<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\ProfessionalServices;

class Leads extends Model
{
    use HasFactory;
    protected $table = "leads";

    public function VisaService()
    {
        return $this->belongsTo('App\Models\ProfessionalServices','visa_service_id','unique_id');
    }

    public function Service($id)
    {
        $service = DB::table(MAIN_DATABASE.".visa_services")->where("unique_id",$id)->first();
        return $service;
    }
    public function AssingedMember()
    {
        return $this->hasMany('App\Models\AssignLeads','leads_id','unique_id')->with(['Member']);
    }
    static function deleteRecord($id){
        Leads::where("id",$id)->delete();
    }

    public function Assessments($lead_id)
    {
        $service = DB::table(MAIN_DATABASE.".external_assessments as ea")
                    ->select("ea.*","ast.assessment_title")
                    ->leftJoin(MAIN_DATABASE.'.assessments as ast', 'ast.unique_id', '=', 'ea.assessment_id')
                    ->where("lead_id",$lead_id)
                    ->get();
        return $service;
    }
}
