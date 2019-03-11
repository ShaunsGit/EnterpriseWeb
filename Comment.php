<?php 
//Comment.php Inserts the new comments made into the database and also emails the owner of the post about the new comments
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');


$comment = $_REQUEST["com"];
$postID = $_REQUEST["postID"];
$userID = $_REQUEST['userID'];



//email user
// 1. Get the the Email of the PostID.
// 2. Send an email to the original poster

    $query = "SELECT StaffID, CategoryID FROM Posts Where PostID=$postID";
    $result = mysqli_query($link, $query);
         if (mysqli_num_rows($result) >= 1){
            while($row = mysqli_fetch_assoc($result)) {
                $postAuthorID = $row['StaffID'];      
            }
             
            $query = "SELECT Email, Name FROM Staff Where StaffID=$postAuthorID";
             $result = mysqli_query($link, $query);
         if (mysqli_num_rows($result) >= 1){
            while($row = mysqli_fetch_assoc($result)) {
                $email = $row['Email'];
                $name = $row['Name'];
            }
             
         }
         }
        


    $ps =  $link->prepare("INSERT INTO Comments(PostID, StaffID, Text, Date_Posted) VALUES(?,?,?,?)");
        //setting the the query
        $ps->bind_param("iiss", $PostID, $StaffID, $Text, $Date_Posted);
        
        //assigning the data to the values.
        $PostID = $postID;
        $StaffID =$userID;
        $Text = $comment;
        $Date_Posted = date("d/m/Y");
      
        $result = $ps->execute();
        $currPostId = $ps->insert_id; //stores the recent post id in the currPostId variable
    
        if($result){
                $subject = "New Comment on your post!";
                mail($email, $subject , "Dear $name, there has been a comment added to your post.\n\n The comment made is: \"$Text\"\nDate Posted: ". date("d/m/Y"), "From: sm2418r@gre.ac.uk");
        }
?>
