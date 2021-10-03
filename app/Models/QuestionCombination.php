<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionCombination extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        QuestionCombination::where("id",$id)->delete();
    }

    static function QuestionInfo($question_id){
        $ques = EligibilityQuestions::where("unique_id",$question_id)->first();
        return $ques;
    }
    
    public function Component()
    {
        return $this->belongsTo('App\ComponentQuestions','component_id');
    }
    static function OptionInfo($option_id){
        $options = QuestionOptions::where("id",$option_id)->first();
        return $options;
    }
}
