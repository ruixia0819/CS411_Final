<?php


// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
}

// require_once("class/query1_class.php");
// $query1 = new Query1();


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
   
    header("Location: query1.php");
    exit;

}
elseif(isset($_POST["skip_button"])){
		header("Location: query_Price.php");
    	exit;
	}

elseif(isset($_POST["submit_button"])){
        $_SESSION["style"] = array();
    
   

    if(isset($_POST['Italian'])=='Yes'){
        array_push($_SESSION["style"],"Italian");
    }
    if(isset($_POST['Mexico'])=='Yes'){
        array_push($_SESSION["style"],"Mexico");
    }
    if(isset($_POST['Pizza'])=='Yes'){
        array_push($_SESSION["style"],"Pizza");
    }
    if(isset($_POST['Hamburgers'])=='Yes'){
        array_push($_SESSION["style"],"Hamburgers");
    }
    if(isset($_POST['Hamburgers'])=='Yes'){
        array_push($_SESSION["style"],"Sandwiches");
    }

     header("Location: query_Price.php");
    exit;

}
        
include("query_Western.html"); 

// public function doQuery(){
// } 



?>