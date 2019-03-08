<?php 
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');


$postId = $_REQUEST["PostID"];
$type = $_REQUEST["type"];
$userId = $_REQUEST["UserID"];
$checkVote = $_REQUEST['q'];


  
    

$query =  "SELECT * FROM Vote WHERE StaffID = $userId and PostID = $postId";

$result = mysqli_query($link, $query);

if(mysqli_num_rows($result) >= 1){
    echo"Deny";
}
else{
    $query = "INSERT INTO Vote(StaffID, PostID, Vote_Type) VALUES($userId,  $postId, '$type')";

    //echo $query;
    
    if(mysqli_query($link, $query)){
        echo "Vote has been added to the db";
    }  
}
        
?>
