<?php 
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');



$postID = (int)$_REQUEST["postID"];

//$query = "SELECT * FROM Comments WHERE PostID=" . $postID . "INNER JOIN Staff
//on Comment.StaffID = Staff.StaffID ORDER BY CommentID DESC";
$query = "SELECT Comments.StaffID,PostID,Text,Date_Posted,Staff.Name, Department.Department, Staff.DepartmentID
FROM Comments 
INNER JOIN Staff
on Comments.StaffID = Staff.StaffID 
INNER JOIN Department
on Staff.DepartmentID = Department.DepartmentID
where PostID =" . $postID;

$result = mysqli_query($link,$query);

if(mysqli_num_rows($result) > 0){
   
    while($row = mysqli_fetch_assoc($result)) {
//        echo "<p>User:" . $row['StaffID'] . "</p>";
//        echo "<p>Post:" . $row['PostID'] . "</p>";
//        echo "<p>Text:" . $row['Text'] . "</p>";
        
        
//                 <div class="card">
//                    <div class="card-body">
//                        <p class="card-title"><u>Commenter Name</u> - Department</p>
//                        <div class="card-comment"> lorem alkdn alknlw nlnd alndawnid on oianwd iawnd oaiwnd oawdn oaiwdn oaw;'fn waiena ofhneoi hnfeoisf heoifjh oi</div><br />(Date Posted)
//                        <div id="tester">dadw</div>
//                    </div>
//                </div>
                
                
                
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<p class="card-title"><u>'.$row['Name'].'</u> - '.$row['Department'].'</p>';
                echo '<div class="card-comment">'.$row['Text'].'</div><br />Posted: '.$row['Date_Posted'];
                echo '<a onclick="DeleteComment()" class="btn btn-danger btn-sm right">Delete</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
        
    }
}

?>
