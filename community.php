<?php
require_once("class/community_class.php");
session_start();
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

    

if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1 ) {
    $page = new Record();
    if(isset($_GET['id'])){
        $join = $_GET['id'];
        $page->joinMeal($join);
    }
    
    $page->getRecord();
    $len = sizeof($page->inviters);
    $addrs = $page->addrs;
    $inviters = $page->inviters;
    $restaurants = $page->restaurants;
    $peoples = $page->peoples;
    $post_id = $page->post_id;
    $sizeofPeople = sizeof($peoples);
    $result="";
    // for($x=0;$x<$len;$x++){
    //     //array_push($addrs,$page->addrs[$x]);
    //     array_push($inviters,$page->inviters[$x]);
    //     array_push($restaurants,$page->restaurants[$x]);
    // }
    //echo $addrs[0];
    //echo $len;
    //$result="<li class='article-entry standard'><h3>Going to Padda Express. Anyone together?</h3><h4><a href='single.html'>Erica,</a><a href='single.html'>Joe,</a><a href='single.html'>Rui, </a>and 5 more are going</h4><span class='article-meta'>12:15 25 Apr, 2017 @ <a href='#' title='View all posts in Server &amp; Database'>Padda Express</a></span><span class='like-count'>66</span></li>";
    for($x = 0; $x < $len; $x++){
        // $result = $result."<li class='article-entry standard'><h3>".$page->messages[$x].
        //           "</h3><h4>".$page->inviters[$x].
        //           " invites ".$page->attenders[$x].
        //           "</h4><span class='article-meta'>".$page->timeStamps[$x].
        //           "@ <a href='#' title='View all posts in Server &amp; Database'>".$page->restaurants[$x].
        //           "</a></span><span class='like-count'><a href='community.php?id=".$post_id[$x]."'>join</a></span></li>";
        $result = $result."<article class='format-standard type-post hentry clearfix'><header class='clearfix'>
                            <h3 class='post-title'><a>".$page->messages[$x].
                            "</a></h3><div class='post-meta clearfix'><span class='author'>Invitor:".$page->inviters[$x].
                            "</span><span class='date'>".$page->timeStamps[$x].
                            "</span><span class='category'>".$page->restaurants[$x].
                            "</span><span class='comments'>Follow by ".$page->attenders[$x].
                            "</span><span class='like-count'><a href='community.php?id=".$post_id[$x].
                            "'>join</a></span></div></header></article>";
    }
    // for($x = 0; $x < $len; $x++){
    //       $result= $result."hi";
    // }
    
    include('community.html');
      
}
else{
 header("Location: Login.php");
    exit; 
}