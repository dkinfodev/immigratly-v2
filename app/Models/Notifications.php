<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = "notifications";

    static function deleteRecord($id){
        Notifications::where("id",$id)->delete();
    }

    public function NotificationData()
    {
        return $this->hasMany('App\Models\NotificationData','notification_id','unique_id');
    }
    public function Read()
    {
    	$user_id = \Auth::user()->unique_id;
		$role = \Auth::user()->role;
        return $this->hasOne('App\Models\NotificationRead','notification_id')
        		->where("user_id",$user_id)
				->where("user_role",$role);
    }
    static function NotificationRead($id)
    {
		$user_id = \Auth::user()->unique_id;
		$role = \Auth::user()->role;
		$is_read = NotificationRead::where("notification_id",$id)
									->where("user_id",$user_id)
									->where("user_role",$role)
									->count();
		return $is_read;
    }
}
