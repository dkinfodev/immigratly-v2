<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);
$db = '';
if(!isset($_POST['db'])){
    return false;
}else{
    $db = $_POST['db'];
}
if($_SERVER['HTTP_HOST'] == 'localhost'){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "immigrat_sampledb"; // Host Database

    // Users database

    $servername2 = "localhost";
    $username2 = "root";
    $password2 = "";
    $dbname2 = $db;
}else{
    $servername = "localhost";
    $username = "immigrat_immigratly";
    $password = "PHx#t;qv1p]S";
    $dbname = "immigrat_sampledb"; // Host Database

    // Users database

    $servername2 = "localhost";
    $username2 = "immigrat_immigratly";
    $password2 = "PHx#t;qv1p]S";
    $dbname2 = $db;
}

$conn_host = new mysqli($servername, $username, $password, $dbname);
if ($conn_host->connect_error) {
    $response['status'] = true;
    $response['error_exists'] = true;
    $html = '<tr class="text-danger"><td><i class="fa fa-times"></i> '.$dbname.'</td>';
    $html .= '<td>'.$conn_host->connect_error.'</td></tr>';
    $response['html'] = $html;
    echo json_encode($response);
    exit;  
}


$html = '';
if($dbname2 != ''){
    
    $conn_local = new mysqli($servername2, $username2, $password2, $dbname2);
    if ($conn_local->connect_error) {
        $response['status'] = true;
        $html = '<tr class="text-danger"><td><i class="fa fa-times"></i> '.$dbname2.'</td>';
        $html .= '<td><span>Database not found</span></td></tr>';
        $response['database'] = $dbname2;
        $response['html'] = $html;
        echo json_encode($response);
        exit;    
    }


    $error = 0;
    $errorMsg = '';
    $success = 0;
    $sql = "SHOW TABLES";
    $results_new = $conn_host->query($sql);

    $new_tables = array();
    if ($results_new->num_rows > 0) {
        // output data of each row
        while($row = $results_new->fetch_assoc()) {
            $new_tables[] = $row['Tables_in_'.$dbname];
        }
    }

    $sql = "SHOW TABLES";
    $result_old = $conn_local->query($sql);

    $old_tables = array();
    if ($result_old->num_rows > 0) {
        // output data of each row
        while($row = $result_old->fetch_assoc()) {
            $old_tables[] = $row['Tables_in_'.$dbname2];
        }
    }


    $tables_new = array_diff($new_tables,$old_tables);
    $tables_new = array_values($tables_new);
    
    // Create New Tables
    for($t = 0;$t < count($tables_new);$t++){
        $sql = "SHOW COLUMNS FROM ".$tables_new[$t];
        $results = $conn_host->query($sql);
        $columns = array();
        while($row = $results->fetch_assoc()) {
            // pre($row);
            $null = '';
            $primary = '';
            if($row['Null'] == 'NO'){
                $null = "";
            }
            if($row['Null'] == 'YES'){
                $null = "NULL";
            }
            if($row['Key'] == 'PRI'){
                $primary = "PRIMARY KEY (".$row['Field'].")";
            }
            $columns[] = '`'.$row['Field'].'` '.$row['Type'].' '.$null;
        }
        $cols = implode(",",$columns);
        $sql2 = "CREATE TABLE `$tables_new[$t]` ($cols) ".$primary;
        // echo "Table Created:".$tables_new[$t]."<br><br>";
        // echo nl2br($sql2)."<br><br>";
        if($conn_local->query($sql2)){
            // echo "success<br>";
            $success++;
        }else{
            $error++;
            $errorMsg .='<i class="fa fa-check"></i> Error while creating Table '.$tables_new[$t].'<br>';
            $errorMsg .='<div class="text-warning">'.$sql2.'</div>';
            // echo $errorMsg;
        }
        // echo $sql2."<br>";
    }
    // Create New Columns
    $tables = array();
    for($c = 0;$c < count($new_tables);$c++){
        $tbl = $new_tables[$c];
    
        if(!isset($tables[$tbl])){
            $sql = "SHOW COLUMNS FROM ".$tbl;
            $results = $conn_host->query($sql);
            $columns = array();
            while($row = $results->fetch_assoc()) {
                $column = $row['Field'];
            
                $sql2 = "SHOW COLUMNS FROM `$tbl` LIKE '$column'";
                $res2 = $conn_local->query($sql2);
                // echo $dbname2."<br>";
                // echo $sql2."<br>";
                if ($res2->num_rows <= 0) {
                    $tables[$tbl][] = $column;
            
                    $null = '';
                    $primary = '';
                    if($row['Null'] == 0){
                        $null = "";
                    }
                    if($row['Key'] == 'PRI'){
                        $primary = "PRIMARY KEY AUTO_INCREMENT";
                    }
                    $sql3 = "ALTER TABLE $tbl ADD COLUMN $column ".$row['Type']." ".$null." ".$primary;
                    // echo "New Column Added:".$tbl."::".$column."<br><br>";
                    if($conn_local->query($sql3)){
                        $success++;
                    }else{
                        $error++;
                        $errorMsg .='Error while Alter Table '.$tbl.'<br>';
                        $errorMsg .='<div class="text-warning">'.$sql3.'</div>';
                    }
                    
                }
            }
        
        }
    }

    $sql = "SHOW TABLES";
    $results_new = $conn_host->query($sql);

    $new_tables = array();
    if ($results_new->num_rows > 0) {
        while($row = $results_new->fetch_assoc()) {
            $new_tables[] = $row['Tables_in_'.$dbname];
        }
    }

    $sql = "SHOW TABLES";
    $result_old = $conn_local->query($sql);

    $old_tables = array();
    if ($result_old->num_rows > 0) {
        // output data of each row
        while($row = $result_old->fetch_assoc()) {
            $old_tables[] = $row['Tables_in_'.$dbname2];
        }
    }

    $tables = array();
    for($c = 0;$c < count($new_tables);$c++){
        $tbl = $new_tables[$c];
    
        if(!isset($tables[$tbl])){
            $sql = "SHOW COLUMNS FROM ".$tbl;
            $results = $conn_host->query($sql);
            $columns = array();
            // echo "TABLE: ".$tbl."<br>";


            while($row = $results->fetch_assoc()) {
                // pre($row);
                $column = $row['Field'];
            
                $sql2 = "SHOW COLUMNS FROM `$tbl` LIKE '$column'";
                $res2 = $conn_local->query($sql2);
                $column_detail = $res2->fetch_assoc();

                foreach($row as $k => $value){
                    
                    if($row[$k] != $column_detail[$k]){
                        if($k != 'Extra'){
                            // echo $k."<br>";
                            $null = '';
                            $default = '';
                            $key = '';
                            $type = $row['Type'];
                            if($type == 'int(255)'){
                                $type = 'int(11)';
                            }
                            if($k == 'Null'){
                                if(strtolower($value) == 'yes'){
                                    $null = ' NULL';
                                }else{
                                    $null = '';
                                }
                            }
                            if($k == 'Key'){
                                if($value == 'PRI'){
                                    $key = " PRIMARY KEY AUTO_INCREMENT";
                                }
                            }
                            if($k == 'Default'){
                                if($value != NULL){
                                    if($value == 'current_timestamp()' || $value == 'CURRENT_TIMESTAMP'){;
                                        $default = " NOT NULL DEFAULT CURRENT_TIMESTAMP";
                                    }else{
                                        $default = " DEFAULT '".$value."'";
                                    }
                                    
                                }else{
                                    $default = " DEFAULT ".$value;
                                }
                            }
                            $sql3 = "ALTER TABLE `$tbl` CHANGE `$column` `$column` $type ".$key.$null.$default;
                            if($value != ''){
                                if($conn_local->query($sql3)){
                                    $success++;
                                    // echo "success";
                                }else{
                                    $error++;
                                    $errorMsg .='Error while Alter Table '.$tbl.'<br>';
                                    $errorMsg .='<div class="text-warning">'.$sql3.'</div>';
                                    // echo "<pre>";
                                    // print_r($errorMsg);
                                    // echo "</pre>";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $conn_host->close();
    $conn_local->close();
    $response['status'] = true;
    $response['database'] = $dbname2;
    if($error > 0){
        $message ="<div class='text-danger'>".$error." Errors while updating database<br>".$errorMsg."</div>";
    }else{
        $message ="<div class='text-success'> Database Updated successfully</div>";
    }
    // $response['message'] = 'Database replicate successfully';
    $response['status'] = true;
    if($errorMsg != ''){
        $response['error_exists'] = true;
    }else{
        $response['error_exists'] = false;
    }
    // echo $message;
    $html = '<tr><td>'.$dbname2.'</td>';
    $html .= '<td>'.$message.'</td></tr>';
    $response['html'] = $html;
    echo json_encode($response);
    exit;  
}else{
    $response['status'] = false;
    $response['message'] = 'database not selected';
    echo json_encode($response);
    exit;
}

function pre($value){
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}
?> 

