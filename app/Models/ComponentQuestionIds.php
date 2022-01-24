<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentQuestionIds extends Model
{
    use HasFactory;

    public function Component()
    {
        return $this->belongsTo('App\Models\ComponentQuestions','component_id','unique_id');
    }

    public function EligibilityQuestion()
    {
        return $this->belongsTo('App\Models\EligibilityQuestions','question_id','unique_id');
    }

    public function ComponentGroups()
    {
        return $this->belongsTo('App\Models\GroupComponentIds','component_id','component_id')
                    ->with("QuestionsGroups");
    }
}
