<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuestionIds extends Model
{
    use HasFactory;

    public function Question()
    {
        return $this->belongsTo('App\Models\EligibilityQuestions','question_id','unique_id');
    }
    
    public function Component()
    {
        return $this->belongsTo('App\Models\ComponentQuestions','component_id','unique_id');
    }
}
