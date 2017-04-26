<?php


// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
//require_once("db.php");

// load the login class
require_once("class/Login_class.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login_class();
session_start();
if (isset($login)) {
        if ($login->errors) {
           /* foreach ($Login_class->errors as $error) {
                echo "<script>alert('$error')</script>";
                echo $error;
            }*/
           $result='<div class="alert alert-danger" role="alert">
					<strong>Oh snap!</strong>'.'   '.$login->errors[0].'
				</div>';
        }

      if ($login->messages) {
           /* foreach ($registration->messages as $message) {
                 echo "<script>alert('$message')</script>";
                 // echo $error;
            }*/
          $result='<div class="alert alert-success" role="alert">
					<strong>Congratulation!</strong>'.'    '. $login->messages[0].'</div>';  
        }
    }

// ... ask if we are logged in here:
//$login->isUserLoggedIn() == true
if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1 ) {
    // echo "<script>alert('you have sucessfully logged in')</script>";
    header("Location: query1.php");
    exit;   

   
}

include("login.html");  