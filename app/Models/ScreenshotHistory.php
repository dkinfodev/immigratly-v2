<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenshotHistory extends Model
{
    use HasFactory;

    protected $table = "screenshot_history";
    
    static function deleteRecord($id){
        $record = ScreenshotHistory::with('ScreenCapture')->where("id",$id)->first();
        $dir = $record->ScreenCapture->id;
        $path = public_path('uploads/screen-capture/'.$dir."/");
        if(file_exists($path.$record->image_name)){
            unlink($path.$record->image_name);
        }
        ScreenshotHistory::where("id",$id)->delete();
        
    }
    
    public function ScreenCapture()
    {
        return $this->belongsTo('App\Models\ScreenCapture','sc_id');
    }
}
