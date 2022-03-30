<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStages extends Model
{
    use HasFactory;
    protected $table = "case_stages";

    static function deleteRecord($id){
        CaseStages::where("id",$id)->delete();
    }
    
    public function Case()
    {
        return $this->belongsTo('App\Models\Cases','case_id','unique_id');
    }


}
