<?php 
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');


$postId = (int)$_REQUEST["q"];
$query = "SELECT Up_Vote From Posts Where PostID = " . $postId;
$result = mysqli_query($link,$query);
$newPostCount;

if(mysqli_num_rows($result) > 0){
   
    while($row = mysqli_fetch_assoc($result)) {
        $newPostCount = (int)$row['Up_Vote'];
    }
    
    
    $newPostCount += 1; 
    $query = "UPDATE Posts SET Up_Vote = " .$newPostCount. " WHERE PostID = " . $postId;
    
    mysqli_query($link,$query);
    echo "Up ". $newPostCount;
        
    
 
}

?> 