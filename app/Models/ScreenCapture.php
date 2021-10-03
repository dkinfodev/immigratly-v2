<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenCapture extends Model
{
    use HasFactory;

    protected $table = "screen_capture";
    
    static function deleteRecord($id){
        ScreenCapture::where("id",$id)->delete();
        ScreenshotHistory::where("sc_id",$id)->delete();
    }
    
    public function ScreenshotHistory()
    {
        return $this->hasMany('App\Models\ScreenshotHistory','sc_id');
    }
    
    public function UnreadScreenshot()
    {
        return $this->hasMany('App\Models\ScreenshotHistory','sc_id')->where("is_read",0);
    }
}
