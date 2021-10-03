<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseTaskComments extends Model
{
    use HasFactory;
    protected $table = "case_task_comments";

    static function deleteRecord($id){
        CaseTaskComments::where("id",$id)->delete();
    }
    public function Task()
    {
        return $this->belongsTo('App\Models\CaseTasks','task_id','unique_id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User','send_by','unique_id');
    }
}
