<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupComponentIds extends Model
{
    use HasFactory;

    public function Questions()
    {
        return $this->hasMany('App\Models\ComponentQuestionIds','component_id','component_id');
    }

    public function QuestionsGroups()
    {
        return $this->belongsTo('App\Models\QuestionsGroups','group_id','unique_id');
    }
    
    public function Component()
    {
        return $this->belongsTo('App\Models\ComponentQuestions','component_id','unique_id')
                    ->with("Questions");
    }

    public function ConditionalQuestion()
    {
        return $this->hasMany('App\Models\ConditionalQuestions','component_id','component_id');
    }

    
}
