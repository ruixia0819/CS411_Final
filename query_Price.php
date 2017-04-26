<?php


// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
}


require_once("class/query_class.php");
require_once("class/recommend.php");



session_start();


// login via post data (if user just submitted a login form)
if (isset($_POST["logout_button"])) {
    unset($_SESSION['user_login_status']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    unset($_SESSION['taste']);
    unset($_SESSION['hate']);
    unset($_SESSION['favourite']);
    header("Location: Login.php");
    exit;

}

if (isset($_POST["back"])) {
   $_SESSION["style"]=array(); //reset the array
   $_SESSION["price"]=array();

    header("Location: query1.php");
    exit;

}

elseif(isset($_POST["submit_button"])||isset($_POST["skip_button"])){
    $_SESSION["price"] = array();
    
    if(isset($_POST['price1'])=='Yes'){
        array_push($_SESSION["price"],"Less than $10");
    }
    if(isset($_POST['price2'])=='Yes'){
        array_push($_SESSION["price"],"$10-$20");
    }
    if(isset($_POST['price3'])=='Yes'){
        array_push($_SESSION["price"],"$20-$30");
    }
    if(isset($_POST['price4'])=='Yes'){
        array_push($_SESSION["price"],"More than $30");
    }
    
    header("Location: result.php");
    
    $query = new Query();
    $query->doQuery();
    
    
    $recomend = new Recommend();
    $recomend->doRecommend();

    
     exit;

}



        
include("query_Price.html"); 





?>