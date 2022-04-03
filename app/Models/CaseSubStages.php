<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseSubStages extends Model
{
    use HasFactory;
    protected $table = "case_sub_stages";

    static function deleteRecord($id){
        CaseSubStages::where("id",$id)->delete();
    }
    
    public function Case()
    {
        return $this->belongsTo('App\Models\Cases','case_id','unique_id');
    }


}
