<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarTopics extends Model
{
    use HasFactory;
    protected $table = "webinar_topics";

    static function deleteRecord($id){
        WebinarTopics::where("id",$id)->delete();
    }
}
