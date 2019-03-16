<?php 
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');



$postID = $_REQUEST["postID"];
$title = $_REQUEST["title"];
$cate = $_REQUEST["cate"];
$desc = $_REQUEST["desc"];




$desc = preg_replace('/\s+/', ' ', $desc);

$query = "Update Posts SET CategoryID=".$cate.", Title='".$title."', Description='".$desc."' WHERE PostID=".$postID;



if (mysqli_query($link, $query)) {
    echo "Record updated successfully";
}
?>