<?php 
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');



$comID = (int)$_REQUEST["comID"];
$postID = (int)$_REQUEST["postID"];




echo $comID;

$query = "DELETE From Comments where CommentID=$comID";


if(mysqli_query($link,$query)){
    echo $postID;
}
?>
