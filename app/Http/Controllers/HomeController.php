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
        if(\Session::get("login_to") != 'admin_panel'){
            if(\Auth::check()){
                return redirect(baseUrl('/'));
            }else{
                return redirect('/login');
            }
        }
        else{
           
            $now = \Carbon\Carbon::now();
            $articles = Articles::where("status","publish")
                            ->whereHas("Category")
                            ->orderBy('id','desc')
                            ->limit(4)
                            ->get();
            
            $news = News::where(DB::raw("(STR_TO_DATE(news_date,'%d-%m-%Y'))"), ">=",$now)
                        ->orderBy("id",'desc')
                        ->limit(4)
                        ->get();

            $webinars = Webinar::where("status","publish")
                            ->whereHas("Category")
                            ->where(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"), ">=",$now)
                            ->orderBy(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"),'desc')
                            ->limit(4)
                            ->get();

            $professionals = Professionals::orderBy('id','desc')
                            ->limit(6)
                            ->get();
           
            $viewData['webinars'] = $webinars;
            $viewData['professionals'] = $professionals;
            $viewData['articles'] = $articles;   
            $viewData['news'] = $news;   
            $viewData['pageTitle'] = "Home Page";   
            return view('frontend.index',$viewData);
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
              $tb = $table->Tables_in_new_immigratly;
              $colums = DB::select("SHOW COLUMNS FROM new_immigratly.".$tb);
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
