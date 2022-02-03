<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrangeGroups extends Model
{
    use HasFactory;

    public function Group()
    {
        return $this->belongsTo('App\Models\QuestionsGroups','group_id','unique_id');
    }

    public function Components()
    {
        return $this->hasMany('App\Models\GroupComponentIds','group_id','group_id')
        // ->doesntHave("ConditionalQuestion")
        ->with("Component")
        ->whereHas("Component")
        ->orderBy("sort_order","asc");
    }

    static function checkIfConditional($component_id,$conditional_type){
        $conditional = ConditionalQuestions::where("component_id",$component_id)
                        ->where("condition_type",$conditional_type)
                        ->first();    
        return $conditional;
    }

    static function checkIfGroupConditional($group_id,$component_id){
        $conditional = GroupConditionalQuestions::where("component_id",$component_id)
                                            ->where("group_id",$group_id)
                                            ->first();    
        return $conditional;
    }

    static function checkConditionalQues($question_id){
        $conditional = ConditionalQuestions::where("question_id",$question_id)->first();    
        return $conditional;
    }
    static function checkGroupConditionalQues($group_id,$component_id,$question_id){
        $conditional = GroupConditionalQuestions::where("parent_component_id",$component_id)
                                            ->where("group_id",$group_id)
                                            ->where("question_id",$question_id)
                                            ->first();    
        return $conditional;
    }

    

    static function GroupConditional($group_id,$component_id,$question_id){
        $conditional = GroupConditionalQuestions::where("group_id",$group_id)
                                                ->where("component_id",$component_id)
                                                ->where("question_id",$question_id)
                                                ->first();    
        return $conditional;
    }
}
