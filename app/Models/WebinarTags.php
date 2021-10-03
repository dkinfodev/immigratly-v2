<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarTags extends Model
{
    use HasFactory;
    protected $table = "webinar_tags";

    static function deleteRecord($id){
        WebinarTags::where("id",$id)->delete();
    }
}
