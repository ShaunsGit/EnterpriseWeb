<?php 
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');



$postID = (int)$_REQUEST["postID"];




$query = "SELECT Count(*) as total FROM Comments where PostID=$postID";

$result = mysqli_query($link,$query);

if(mysqli_num_rows($result) > 0){
   
    while($row = mysqli_fetch_assoc($result)) {
        echo $row['total'];
    }}
?>
