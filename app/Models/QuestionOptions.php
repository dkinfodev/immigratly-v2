<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOptions extends Model
{
    use HasFactory;
    protected $table = "question_options";

    static function deleteRecord($id){
        QuestionOptions::where("id",$id)->delete();
        CombinationalOptions::where("option_one_id",$id)->orWhere("option_two_id",$id)->delete();

    }

    public function Question()
    {
        return $this->belongsTo('App\Models\EligibilityQuestions','question_id','unique_id');
    }

    public function LanguageProficiency()
    {
        return $this->belongsTo('App\Models\LanguageProficiency','language_proficiency_id','unique_id');
    }
}
