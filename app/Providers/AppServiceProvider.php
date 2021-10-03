<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\VisaServices;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $host = explode('.', request()->getHost());
        $host = $host[0];
        if($host != 'localhost'){
            $url = url()->current();    
            $key = "www.";
            if (strpos($url, $key) != false) {
                $new_url = str_replace("www.","",$url);
                header("Location: ".$new_url);
                die();
            }
        }
        $visa_services = VisaServices::with('SubServices')
                                    ->where("parent_id",0)
                                    ->select("id","name","slug","unique_id")
                                    ->get();
       
        view()->share('visa_services', $visa_services);
    }
}
