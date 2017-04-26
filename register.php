<?php

/**
 * A simple, clean and secure PHP Login Script / MINIMAL VERSION
 *
 * Uses PHP SESSIONS, modern password-hashing and salting and gives the basic functions a proper login system needs.
 *
 * @author Panique
 * @link https://github.com/panique/php-login-minimal/
 * @license http://opensource.org/licenses/MIT MIT License
 */

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

// load the registration class
require_once("class/Registration.php");

// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$registration = new Registration();

session_start();


if (isset($registration)) {
            //header("Location:Login.php");
	    if ($registration->errors) {
	        //foreach ($registration->errors as $error) {
	          //  echo "<script>alert('$error')</script>";
	            
	            // echo $error;
                    $result='<div class="alert alert-danger" role="alert">
					<strong>Oh snap!</strong>'.'   '.$registration->errors[0].'
				</div>';

	        
	    }
	    if ($registration->messages) {
	       // foreach ($registration->messages as $message) {
                        $_SESSION['user_login_status'] = 1;
                        $_SESSION['user_name'] = $user_name;
                        $_SESSION['user_email'] = $user_email;
                        $result='<div class="alert alert-success" role="alert">
					<strong>Congratulation!</strong>'.'    '. $registration->messages[0].'</div>';
                        header("Location: Login.php");
                        exit;  
	           //  echo "<script>alert('$message')</script>";
                        

	             // echo $error;
	       // }
	    }
	}

// if (isset($registration)) {
	    
// 	    echo "<script>alert('mdzz!')</script>";
// 	}

include("register.html")					

?>


