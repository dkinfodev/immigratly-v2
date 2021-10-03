<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationRead extends Model
{
    use HasFactory;
    protected $table = "notification_read";

    static function deleteRecord($id){
        NotificationRead::where("id",$id)->delete();
    }

    public function Notification()
    {
        return $this->belongsTo('App\Models\Notifications','notification_id','unique_id');
    }
}
