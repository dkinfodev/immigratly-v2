<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrangeQuestions extends Model
{
    use HasFactory;

    public function Question()
    {
        return $this->belongsTo('App\Models\EligibilityQuestions','question_id','unique_id')->with("Options");
    }
}
