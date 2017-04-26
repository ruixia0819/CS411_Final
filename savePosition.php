<?php
session_start();

if(isset($_POST['lat'], $_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
// if(isset($_GET['lat'],$_GET['lng'])){
//     $lat=$_GET['lat'];
//     $lng=$_GET['lng'];
    echo $lat;
    echo $lng;
    $db_connection = new mysqli("localhost", "queenoflibra_ruixia2", "Aptx4869", "queenoflibra_CS411Database");
    $my_name = $_SESSION['user_name'];
    $my_email = $_SESSION['user_email'];
    //$test = "UPDATE `position` SET lng ='3'  WHERE user_name = 'erica'";
    $check = "SELECT * FROM position WHERE user_name='".$my_name."'";
    echo $check;
    $check_result = $db_connection->query($check);
    if($check_result->num_rows!=0){
        $test = "UPDATE position SET lat='".$lat."', lng='".$lng."' WHERE user_email='".$my_email."'AND user_name = '".$my_name."'";
    }else{
        $insert = "INSERT INTO position (user_name,user_email,lat,lng) VALUES ('" .$my_name. "','" .$my_email. "',0,0)";
       // $insert="INSERT INTO position (user_name,user_email,lat,lng) VALUES ('rioxiarui','rioxiarui@illinois.edu',0,0)";
        $db_connection->query($insert);
        echo $insert;
        $test="UPDATE position SET lat='".$lat."', lng='".$lng."' WHERE user_email='".$my_email."'AND user_name = '".$my_name."'";;
       //$test= "INSERT INTO position (user_name,user_email,lat,lng) VALUES ('rioxiarui','rioxiarui@illinois.edu',0,0)";
    }
    $result = $db_connection->query($test);
    //$test = "UPDATE position SET lat='".$lat."', lng='".$lng."' WHERE user_name= 'erica'";
    
    // $sql="SELECT * FROM have_posts WHERE poster_name = '".$my_name."' AND poster_email = '".$my_email."' ORDER BY post_id DESC LIMIT 1";
    // $result = $db_connection->query($sql);
    // if($result){
    //     // $obj = $result->fetch_object();
    //     $update = "UPDATE position SET lat='".$lat."', lng='".$lng."' WHERE user_name='".$my_name."' AND user_email='".my_email."'";
    //     $db_connection->query($update);
                       
    // }else{
    //                     //TODO
    // }


   
}

?>
