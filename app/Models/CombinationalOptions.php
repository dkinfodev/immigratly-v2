<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombinationalOptions extends Model
{
    use HasFactory;

    static function deleteRecord($id){
        CombinationalOptions::where("id",$id)->delete();
    }

    public function Question()
    {
        return $this->belongsTo('App\Models\EligibilityQuestions','question_id','unique_id');
    }

    public function OptionOne()
    {
        return $this->belongsTo('App\Models\QuestionOptions','option_one_id');
    }

    public function OptionTwo()
    {
        return $this->belongsTo('App\Models\QuestionOptions','option_two_id');
    }
}
