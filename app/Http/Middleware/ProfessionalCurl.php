<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;
use DB;

use App\Models\DomainDetails;

class ProfessionalCurl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
    */
    public function handle($request, Closure $next)
    {
        $headers = $request->header();
        if(isset($headers['subdomain'][0])){

            $subdomain = $headers['subdomain'][0];
            // $authorization = $headers['authorization'][0];
            $authorization = str_replace("Bearer ","",$headers['authorization'][0]);
            // pre($headers);
            \Config::set('database.connections.mysql.database', PROFESSIONAL_DATABASE.$subdomain);
            \DB::purge('mysql');
            // $data = DB::table(PROFESSIONAL_DATABASE.$subdomain.".domain_details")->first();
            $data = DomainDetails::first();
            
            if(!empty($data)){
                if($data->client_secret != $authorization){
                    $response['status'] = "api_error";
                    $response['error'] = 'invalid_api_key';
                    $response['message'] = "Access denied";    
                    return response()->json($response);
                }
            }else{
                $response['status'] = "api_error";
                $response['error'] = 'invalid_api_key';
                $response['message'] = "Authorization key not found";    
                return response()->json($response);
            }
            return $next($request);
        }else{
            $response['status'] = "api_error";
            $response['error'] = 'invalid_api_key';
            $response['message'] = "Authorization key not found";    
            return response()->json($response);
        }
        // pre($headers);
        return $next($request);
    }
}
