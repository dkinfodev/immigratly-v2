<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseTasks extends Model
{
    use HasFactory;
    protected $table = "case_tasks";

    static function deleteRecord($id){
        $case = CaseTasks::where("id",$id)->first();
        CaseTasks::where("id",$id)->delete();
        CaseTaskComments::where("task_id",$case->unique_id)->delete();
    }
    
    public function Case()
    {
        return $this->belongsTo('App\Models\Cases','case_id','unique_id');
    }

    public function CaseTaskFiles()
    {
        return $this->hasMany('App\Models\CaseTaskFiles','task_id','unique_id');
    }
}
