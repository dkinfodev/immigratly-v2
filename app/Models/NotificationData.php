<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationData extends Model
{
    use HasFactory;
    protected $table = "notification_data";

    static function deleteRecord($id){
        NotificationData::where("id",$id)->delete();
    }

    public function NotificationData()
    {
        return $this->hasMany('App\Models\NotificationData','notification_id','unique_id');
    }
}
