<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EligibilityQuestions extends Model
{
    use HasFactory;

    protected $table = "eligibility_questions";

    static function deleteRecord($id){
        $ques = EligibilityQuestions::where("id",$id)->first();
        
        $options = QuestionOptions::where("question_id",$ques->unique_id)->get();
        foreach($options as $option){
            ConditionalQuestions::where("option_id",$option->id)->delete();
        }
        QuestionOptions::where("question_id",$ques->unique_id)->delete();
        ComponentQuestionIds::where("component_id",$ques->unique_id)->delete();
        ArrangeQuestions::where("question_id",$ques->unique_id)->delete();
        EligibilityQuestions::where("id",$id)->delete();
        GroupQuestionIds::where("question_id",$ques->unique_id)->delete();
    }
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    public function Options()
    {
        return $this->hasMany('App\Models\QuestionOptions','question_id','unique_id');
    }

    public function ComponentQuestions()
    {
        return $this->hasMany('App\Models\ComponentQuestionIds','question_id','unique_id')
                    ->where("component_id","!=",0);
    }

    public function QuestionInGroup(){
        return $this->hasOne('App\Models\ComponentQuestionIds','question_id','unique_id')
                    ->whereHas("ComponentGroups")
                    ->with("ComponentGroups");
    }
    public function ConditionalQuestions()
    {
        return $this->hasMany('App\Models\ConditionalQuestions','question_id','unique_id')->where("conditional_question_id","!=",0);
    }

    public function GroupQuestions()
    {
        return $this->hasMany('App\Models\GroupQuestionIds','question_id','unique_id');
    }
    
    public function ArrangeQuestions()
    {
        return $this->hasOne('App\Models\ArrangeQuestions','question_id','unique_id');
    }
    
    public function CombinationalOptions()
    {
        return $this->hasMany('App\Models\CombinationalOptions','question_id','unique_id');
    }
    public function ComponentQuestionIds()
    {
        return $this->hasMany('App\Models\ComponentQuestionIds','question_id','unique_id')
                ->with("Component");
    }

    static function optionScore($value,$field,$question_id,$lang_prof_id = ''){
        $option = QuestionOptions::where("question_id",$question_id)
                                ->where(function($query) use($value,$field,$lang_prof_id){
                                    if($field == 'value'){
                                        $query->where("option_value",$value);
                                    }
                                    if($field == 'id'){
                                        $query->where("id",$value);
                                    }
                                    if($lang_prof_id != ''){
                                        $query->where("language_proficiency_id",$lang_prof_id);
                                    }
                                })
                                
                                ->first();
        return $option;
    }

    static function isDefaultQues($question_id,$visa_service_id){
        $default_component = ComponentQuestions::where("visa_service_id",$visa_service_id)
                                            ->where("is_default",1)
                                            ->first();
        $record = ComponentQuestionIds::where("question_id",$question_id)
                                    ->where("component_id",$default_component->unique_id)
                                    ->count();
        return $record;
    }
    public function LanguageScorePoints()
    {
        return $this->hasMany('App\Models\LanguageScorePoints','question_id','unique_id');
    }
    
    public function QuestionDependentWith()
    {
        return $this->hasMany('App\Models\ComponentQuestionIds','dependent_question','unique_id')
                        ->where("dependent_question","!=","");
    }
}
