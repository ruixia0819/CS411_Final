<?php

require_once("class/history_query.php");
session_start();


// print "run account.php successfully";

$query = new QueryHis();
$query->doQueryHis();

if(isset($_GET['attitute'])){
        $db_con= new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
    	//UPDATE mytable
        // SET column1 = value1,
        //     column2 = value2
        // WHERE key_value = some_value;
        if (!$db_con->set_charset("utf8")) {
            $db_con->set_charset("utf8");
        }  
	    $sql_pre  = "UPDATE `have_histroy`
                SET `attitude` =";
        $sql_su =" WHERE `restaurant_name`= 
                '".$_GET['object']."'
                AND `user_name`=
                '".$_SESSION['user_name']."'
                ";
                
        $sql=$sql_pre.''.$_GET['attitute'].''.$sql_su;
        
        $db_con->query($sql);
        
        
    }
    
    
if(isset($_GET['delete'])){
    
    $db_con= new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
	
	if (!$db_con->set_charset("utf8")) {
    $db_con->set_charset("utf8");}  
    $sql_pre  = "DELETE FROM  `have_histroy`
                WHERE `date`= 
                '".$_GET['date']."'AND `restaurant_name`= 
                '".$_GET['object']."'
                ";
    
    $sql_su =   "AND `user_name`=
                '".$_SESSION['user_name']."'
                ;";
                
    $sql=$sql_pre.$sql_su;
    

    
    $db_con->query($sql);
    $query = new QueryHis();
    $query->doQueryHis();
   
    
 
}

if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1 ) {
    
    include('Account.html');
      
}


else{
 header("Location: Login.php");
    exit; 
}


