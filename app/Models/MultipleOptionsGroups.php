<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleOptionsGroups extends Model
{
    use HasFactory;

    public function CombinationalOption()
    {
        return $this->belongsTo('App\Models\CombinationalOptions','comb_option_id')->with(['OptionOne','OptionTwo','Question']);
    }
    
    public function QuestionOption()
    {
        return $this->belongsTo('App\Models\QuestionOptions','option_id')->with("Question");
    }
    public function GroupQuestion()
    {
        return $this->belongsTo('App\Models\EligibilityQuestions','group_question_id','unique_id');
    }
    public function Question()
    {
        return $this->belongsTo('App\Models\EligibilityQuestions','question_id','unique_id');
    }
}
