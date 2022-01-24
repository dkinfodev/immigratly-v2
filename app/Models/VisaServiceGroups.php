<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaServiceGroups extends Model
{
    use HasFactory;

    public function VisaServices()
    {
        return $this->hasMany('App\Models\GroupVisaIds','visa_group_id','unique_id')->with("VisaService");
    }

    public function ProgramType()
    {
        return $this->belongsTo('App\Models\ProgramTypes','program_type');
    }

    static function deleteRecord($id){
        $record = VisaServiceGroups::where("id",$id)->first();
        VisaServiceGroups::where("id",$record->id)->delete();
        GroupVisaIds::where("visa_service_id",$record->unique_id)->delete();
    }
}
