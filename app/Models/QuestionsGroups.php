<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsGroups extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        $ques = QuestionsGroups::where("id",$id)->first();
        GroupQuestionIds::where("group_id",$ques->unique_id)->delete();
        GroupComponentIds::where("group_id",$ques->unique_id)->delete();
        QuestionsGroups::where("id",$id)->delete();
    }

   

    public function Questions()
    {
        return $this->hasMany('App\Models\GroupQuestionIds','group_id','unique_id');
    }
    
    public function ArrangeGroups()
    {
        return $this->hasOne('App\Models\ArrangeGroups','group_id','unique_id');
    }

    public function Components()
    {
        return $this->hasMany('App\Models\GroupComponentIds','group_id','unique_id')
                ->with("Component")
                ->orderBy('sort_order',"asc");
    }

    static function GroupConditional($group_id,$component_id,$question_id){
        $conditional = GroupConditionalQuestions::where("group_id",$group_id)
                                                ->where("component_id",$component_id)
                                                ->where("question_id",$question_id)
                                                ->first();    
        return $conditional;
    }
    
}
