<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(\Auth::check()){
            return redirect(baseUrl('/'));
        }else{
            return redirect('/login');
        }
    }
    public function random_number(){
        echo randomNumber();
        
    }
    public function welcome_page(){
        if(\Session::get("professional_register")){
            $viewData['portal_url'] = \Session::get("portal_url");
            $viewData['pageTitle'] = "Welcome";
            $viewData['bodyClass'] = 'aboutus';
            \Session::forget("portal_url");
            \Session::forget("professional_register");
            return view('welcome',$viewData);
        }else{
            return redirect('/');
        }
    }

    public function dbupgrade(){
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table)
        {
              pre($table);
              $tb = $table->Tables_in_immigrately;
              $colums = DB::select("SHOW COLUMNS FROM immigrately.".$tb);
              // pre($colums);
              foreach($colums as $column){
                // pre($column);
                if($column->Key == "PRI" && $column->Extra != 'auto_increment'){
                    $sql = "ALTER TABLE `$tb` CHANGE `".$column->Field."` `".$column->Field."` INT(11) NOT NULL AUTO_INCREMENT;";
                    echo "NO AI<br>";
                    echo $sql."<br>";
                    if(DB::statement($sql)){
                        echo "success<br>";
                    }else{
                        echo "failed<br>";
                    }
                }
                // ALTER TABLE `professional_panel` ADD PRIMARY KEY(`id`);
                if($column->Key != "PRI" && $column->Field == "id" && $column->Extra != 'auto_increment'){
                    echo "NO PRI<br>";
                    pre($tb);
                    $sql = "ALTER TABLE `$tb` ADD PRIMARY KEY(`id`)";
                    if(DB::statement($sql)){
                        echo "Primary success<br>";
                    }else{
                        echo "Primary failed<br>";
                    }
                    $sql = "ALTER TABLE `$tb` CHANGE `".$column->Field."` `".$column->Field."` INT(11) NOT NULL AUTO_INCREMENT;";
                    echo $sql."<br>";
                    if(DB::statement($sql)){
                        echo "AI success<br>";
                    }else{
                        echo "AI failed<br>";
                    }
                    
                }
              }
        }
        exit;
    }
}
