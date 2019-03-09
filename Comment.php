<?php 
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');


$comment = $_REQUEST["com"];
$postID = $_REQUEST["postID"];
$userID = $_REQUEST['userID'];



$string = "Comment: " .$comment . "\nPostID = " . $postID . "\nUserID: " . $userID;
    
    
    $ps =  $link->prepare("INSERT INTO Comments(PostID, StaffID, Text, Date_Posted) VALUES(?,?,?,?)");
        //setting the the query
        $ps->bind_param("iiss", $PostID, $StaffID, $Text, $Date_Posted);
        
        //assigning the data to the values.
        $PostID = $postID;
        $StaffID =$userID;
        $Text = $comment;
        $Date_Posted = date("Y/m/d");
      
        $result = $ps->execute();
        $currPostId = $ps->insert_id; //stores the recent post id in the currPostId variable
    
        if($result){
            echo "Result has been added";
        }
?>
