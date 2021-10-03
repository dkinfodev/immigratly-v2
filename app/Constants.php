<?php
if($_SERVER['SERVER_NAME'] == 'localhost'){
    define("MAIN_DATABASE","new_immigratly");
}else{
    define("MAIN_DATABASE","immigrat_main_immigratly");    
}
define("PROFESSIONAL_DATABASE","immigrat_");
define("ACCESS_DENIED_MSG","Not having access permission");

?>
