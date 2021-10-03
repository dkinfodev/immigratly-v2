<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password','provider_id','provider','role','is_active','is_verified','unique_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function deleteRecord($id){
        User::where("id",$id)->delete();
    }
    
    public function ProfessionalPanel()
    {
        return $this->hasOne('App\Models\ProfessionalPanel','user_id');
    } 

    public function UserDetail()
    {
        return $this->hasOne('App\Models\UserDetails','user_id','unique_id');
    }
    
    public function Experiences()
    {
        return $this->hasMany('App\Models\ClientExperience','user_id','unique_id');
    } 

    public function Educations()
    {
        return $this->hasMany('App\Models\ClientEducations','user_id','unique_id')->with("Degree");
    }

    public function FirstProficiency()
    {
        return $this->hasOne('App\Models\UserLanguageProficiency','user_id','unique_id')->where("type","first_official");
    } 

    public function SecondProficiency()
    {
        return $this->hasOne('App\Models\UserLanguageProficiency','user_id','unique_id')->where("type","second_official");
    } 

    public function ProfessionalDetail()
    {
        return $this->hasOne('App\Models\ProfessionalDetails','user_id');
    } 

    static function ProfessionalClients($domain)
    {   
        $client = DB::table(MAIN_DATABASE.".user_with_professional as uwp")
                    ->select("us.*")
                    ->rightJoin(MAIN_DATABASE.".users as us","uwp.user_id","=","us.unique_id")
                    ->where("uwp.professional",$domain)
                    ->groupBy('uwp.user_id')
                    ->get();
       
        return $client;
    } 

    static function Country($id)
    {
        $data = DB::table(MAIN_DATABASE.".countries")->where("id",$id)->first();
        return $data;
    }

    static function State($id)
    {
        $data = DB::table(MAIN_DATABASE.".states")->where("id",$id)->first();
        return $data;
    }

    static function City($id)
    {
        $data = DB::table(MAIN_DATABASE.".cities")->where("id",$id)->first();
        return $data;
    }
}
