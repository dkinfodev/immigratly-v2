<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentQuestions extends Model
{
    use HasFactory;
    protected $table = "component_questions";

    static function deleteRecord($id){
        $ques = ComponentQuestions::where("id",$id)->first();
        ComponentQuestionIds::where("component_id",$ques->unique_id)->delete();
        ComponentQuestions::where("id",$id)->delete();
        ConditionalQuestions::where("component_id",$ques->unique_id)->delete();
        GroupComponentIds::where("component_id",$ques->unique_id)->delete();
        
    }

    public function Questions()
    {
        return $this->hasMany('App\Models\ComponentQuestionIds','component_id','unique_id')
            ->with('EligibilityQuestion')
            ->whereHas("EligibilityQuestion")
            ->orderBy("sort_order","asc");
    }

    public function GroupComponents()
    {
        return $this->hasMany('App\Models\GroupComponentIds','component_id','unique_id')
                    ->whereHas("Component")
                    ->with("Component");
    }

    static function componentQuestions($component_id){
        $questions = ComponentQuestionIds::with(['EligibilityQuestion'])
            ->where("component_id",$component_id)
            ->get()
            ->toArray();
        return $questions;

    }
}
