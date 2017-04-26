<?php


// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
}

require_once("class/recommend.php");
require_once("class/history_query.php");
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
    unset($_SESSION["r_name"]);
    exit;
}

if (isset($_POST["change"])) {
    header("Location: result.php");
    
    $key = array_search($_SESSION["r_rec_name"], $_SESSION["r_name_query"]);
    if (false !== $key) {
        unset($_SESSION["r_name_query"][$key]);
    }
 
    $recomend = new Recommend();
    $recomend->doRecommend();
    exit;
    
}

if (isset($_POST["go"])) {
    $query = new QueryHis();
    $query->doInsertHis();
    
    header("Location: go.php");
    exit;

}

include("result.html"); 



?>