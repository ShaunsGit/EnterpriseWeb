<?php 
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');



$postID = $_REQUEST["postID"];

$query = "DELETE FROM Posts WHERE PostID=".$postID;

if (mysqli_query($link, $query)) {
    
  
        
        $query = "DELETE FROM Comments WHERE PostID=".$postID;
        if (mysqli_query($link, $query)) {
            echo "Removed Post.";
        }
    }


?>
