<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalStageProfile extends Model
{
    use HasFactory;
    protected $table = 'global_stage_profile';

    static function deleteRecord($id){
    	$record = GlobalStageProfile::where("id",$id)->first();
        GlobalStageProfile::where("id",$id)->delete();
        $stage_ids = GlobalStages::where("profile_id",$record->unique_id)->pluck('unique_id')->toArray();
        GlobalStages::where("profile_id",$record->unique_id)->delete();
        GlobalSubStages::whereIn("stage_id",$stage_ids)->delete();
    }

    public function Service($id)
    {
        $service = \DB::table(MAIN_DATABASE.".visa_services")->where("unique_id",$id)->first();
        return $service;
    }

    public function Stages()
    {
        return $this->hasMany('App\Models\GlobalStages','profile_id','unique_id')->with("SubStages");
    }
}
