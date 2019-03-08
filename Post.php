<!DOCTYPE html>

<?php
//Uploads the data sent from Reister.html to the Staff table in the database.
session_start();
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');
if(!$_SESSION['loggedIn'] == "true"){
   header("location: Login.html?redirect=NotLogged");
}
?>



    <html lang="en-GB">

    <head>
        <title>View Post</title>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

        <link href="main.css" rel="stylesheet" />
        <style>
            .card-text {
                font-size: 18px;

                color: white;
                max-height: 20px;
                text-align: left;

            }
            
            .card {
                height: inherit;
                display: block;
                margin: auto;
                border-style: solid;

                width: 85%;
                border-width: 2px;
                background-color: #093145;

                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                padding-bottom: 5px;
                margin-top: 5px;
            }
            

            .card-body {
                color: #EFD469;

            }

            
            .buttons {
                bottom: 0;
                padding-bottom: 13px;
                padding-top: 5px;
            }
            
            .btn {
                position: relative;
            }
            
            .pagination {
                margin-top: 20px;
            }
            
            .pagButtons {
                position: relative;
                margin: 0 auto;
            }
            
            #date {
                font-size: 12px;
                text-align: right;
                color: black;
            }
            
            .container {
                padding: 0 0 0 0;
                height: 500px;
            }
            
            textarea {
                width: 100%;
            }

        </style>
    <script>
        function Comment() {
            var com =document.getElementById("comment");  
            document.getElementById("tester").innerHTML = com.value;
//            var uploadComment = new XMLHttpRequest();
//            uploadComment.onreadystatechange = function() {
//                if (this.readyState == 4 && this.status == 200) {
//                    
//                }
//                
//            };
//            uploadComment.open("POST", "Comment.php", true);
//            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//            xhttp.send("fname=Henry&lname=Ford");
          

        }

    </script>
        <script>
            function UpVote(PostId) {
                <?php  if($_SESSION['loggedIn']){?>

                //checks if the user has voted on this post
                var checkVote = new XMLHttpRequest();
                checkVote.onreadystatechange = function() {

                    //if the response is successful, then the code below is executed
                    if (this.readyState == 4 && this.status == 200) {

                        //takes the response and creates a boolean variable to see if user can vote
                        var response = this.responseText;
                        var regex = new RegExp("Deny");
                        console.log("Allow vote? = " + response.match(regex));

                        //if the user has voted before then this will be true.
                        var hasVoted = regex.test(response);

                        //if the user has voted before, then change button style to grey
                        if (hasVoted) {
                            $("#likeBtn-" + PostId).removeClass("btn-success");
                            $("#likeBtn-" + PostId).addClass("btn-secondary");
                            $("#dislikeBtn-" + PostId).removeClass("btn-danger");
                            $("#dislikeBtn-" + PostId).addClass("btn-secondary");
                        } else {

                            //if the user hasnt voted , then the table gets updated and their vote added to the vote table.
                            //updates the post table to show incremented votes.
                            var updateRequest = new XMLHttpRequest();
                            updateRequest.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("likeBtn-" + PostId).innerHTML = this.response;
                                    $("#likeBtn-" + PostId).removeClass("btn-success");
                                    $("#likeBtn-" + PostId).addClass("btn-secondary");
                                    $("#dislikeBtn-" + PostId).removeClass("btn-danger");
                                    $("#dislikeBtn-" + PostId).addClass("btn-secondary");
                                }
                            };
                            updateRequest.open("GET", "Upvote.php?q=" + PostId, true);
                            updateRequest.send();
                        }

                    }
                };

                //sends the checkVote request
                checkVote.open("GET", "Vote.php?type=like&PostID=" + PostId + "&UserID=<?php echo $_SESSION['UID']; ?>", true);
                checkVote.send();
                <?php } ?>
            }

            function DownVote(PostId) {
                <?php  if($_SESSION['loggedIn']){?>

                //checks if the user has voted on this post
                var checkVote = new XMLHttpRequest();
                checkVote.onreadystatechange = function() {

                    //if the response is successful, then the code below is executed
                    if (this.readyState == 4 && this.status == 200) {

                        //takes the response and creates a boolean variable to see if user can vote
                        var response = this.responseText;
                        var regex = new RegExp("Deny");
                        console.log("Allow vote? = " + response.match(regex));

                        //if the user has voted before then this will be true.
                        var hasVoted = regex.test(response);

                        //if the user has voted before, then change button style to grey
                        if (hasVoted) {
                            $("#likeBtn-" + PostId).removeClass("btn-success");
                            $("#likeBtn-" + PostId).addClass("btn-secondary");
                            $("#dislikeBtn-" + PostId).removeClass("btn-danger");
                            $("#dislikeBtn-" + PostId).addClass("btn-secondary");
                        } else {

                            //if the user hasnt voted , then the table gets updated and their vote added to the vote table.
                            //updates the post table to show incremented votes.
                            var updateRequest = new XMLHttpRequest();
                            updateRequest.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("dislikeBtn-" + PostId).innerHTML = this.response;
                                    $("#likeBtn-" + PostId).removeClass("btn-success");
                                    $("#likeBtn-" + PostId).addClass("btn-secondary");
                                    $("#dislikeBtn-" + PostId).removeClass("btn-danger");
                                    $("#dislikeBtn-" + PostId).addClass("btn-secondary");
                                }
                            };
                            updateRequest.open("GET", "Downvote.php?q=" + PostId, true);
                            updateRequest.send();
                        }

                    }
                };

                //sends the checkVote request
                checkVote.open("GET", "Vote.php?type=dislike&PostID=" + PostId + "&UserID=<?php echo $_SESSION['UID']; ?>", true);
                checkVote.send();
                <?php } ?>
            }

        </script>
    </head>

    <body>
        <?php
      $postId = $_GET['PostID'];
      
      $query = "SELECT PostID, Posts.StaffID, Staff.Name, Posts.CategoryID, Posts.DepartmentID, Department.Department, Category.Category, UploadID, Title, Date_Posted, Description, Up_Vote, Down_Vote, Anonymous 
      From Posts
      INNER JOIN Department
      ON Posts.DepartmentID = Department.DepartmentID
      INNER JOIN Staff
      ON Posts.StaffID = Staff.StaffID
      INNER JOIN Category
      ON Posts.CategoryID = Category.CategoryID 
      WHERE PostID = $postId";
      
      
      
      $post = mysqli_query($link, $query);
    $style = CheckIfVoted($_SESSION['UID'], $_GET['PostID'], $link);
    // Interate through the results whiles echoing the DIVs.
    if(mysqli_num_rows($post) > 0){
        while($row = mysqli_fetch_assoc($post)) {
            $name = $row['Name'];
            $category = $row['Category'];
            $department = $row['Department'];
            $uploadId = $row['UploadID'];
            $title= $row['Title'];
            $desc= $row['Description'];
            $date= $row['Date_Posted'];
            $upVote= $row['Up_Vote'];
            $downVote= $row['Down_Vote'];
            $anon= $row['Anonymous'];
        }
        
    $date = date("d-m-Y", strtotime($date));
        
    }else{
        echo "Post does not exsist.";
        echo $query;
    }
      
      
      
      
      
      
      ?>
            <img class="img1" alt="A screenshot showing CSS Quick Edit" src="mainpic1.jpg">
            <ul>
                <li>
                    <a href="Home.php">Home</a></li>
                <li style="float:right">
                    <?php
                if($_SESSION['loggedIn'] == true){
                    echo '<li style="float:right">        
                    <a href="Logout.php">Logout</a></li>';
                }else {
                    echo '
                    <li style="float:right">
                    <a href="Register.php">Register</a></li>
                    <li style="float:right">
                    <a href="Login.html">Sign In</a></li>
                    <li>';
                }  if($_SESSION['loggedIn'] == true)
                {
                    echo '<li>
                    <li>
                    <a href="">My Ideas</a></li>
                    <li>
                    <a href="">Edit Ideas</a></li>
                    <li>
                    <a href="IdeaSubmission.php">Add Ideas</a></li>
                    ' ;
                }
                ?>

                        <li>
                            <a href="">Search Idea</a></li>
            </ul>

            <div class="container">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title" style="color: #EFD469"><?php echo $title; ?></h5>
                        <h6  class="card-subtitle" style="color: white"><?php echo $department; ?></h6>
                        <p><br></p>
                        <div>

                            <div style="text-align: center"><u>Category</u></div>
                            <div class="card-text" style="text-align: center">
                                <?php  echo $category; ?>
                            </div>
                            
                            <p><br></p>
                            
                            <div style="text-slign:left"><u>Description</u></div>
                            <div class="card-text">
                                <?php  echo $desc; ?>
                            </div>

                            <p><br></p>
                            <p><br></p>

                            <div style="text-slign:left"><u>Date</u></div>
                            <div class="card-text">
                                <?php  echo $date; ?>
                            </div>

                            <!--<p><br></p>-->

                            <div style="text-align:right"><u>Name</u></div>
                            <div class="card-text" style="text-align:right">

                                <?php  
                                if(!(int)$anon == 1){
                                echo $name;
                                }else{
                                    echo "Anon";
                                } ?>
                            </div>


                            <p><br></p>


                            <div class="buttons" style="color:white">
                                <a onclick="UpVote(<?php echo $_GET['PostID'];?>)" id="likeBtn-<?php echo $_GET['PostID']; ?>" class="btn btn-<?php echo SetStyle($style, "up");?> btn-sm">
                                    <span class="glyphicon glyphicon-thumbs-up"></span> Up
                                    <?php echo $upVote; ?>
                                </a>
                                <a onclick="DownVote(<?php echo $_GET['PostID']; ?>)" id="dislikeBtn-<?php echo $_GET['PostID']; ?>" class="btn btn-<?php echo SetStyle($style, "down"); ?> btn-sm">
                                    <span class="glyphicon glyphicon-thumbs-up"></span> Down
                                    <?php echo $downVote; ?>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        
            <hr />
                <h5 style="text-align:left">Insert your Comments</h5>
                <textarea name="message" id="comment" rows="4">Insert comment.</textarea>
                <div> <button class="button" style="float:right" onclick="Comment()" role="button">Submit Comment</button>
                    <br /><br />
                    
                    
                    <h5 style="text-align:left">All Comments</h5>
                    

                    <div class="card">
                        <div class="card-body">
                            <p class="card-title"><u>Commenter Name</u> - Department</p>
                            <div class="card-comment"> lorem alkdn alknlw nlnd alndawnid on oianwd iawnd oaiwnd oawdn oaiwdn oaw;'fn waiena ofhneoi hnfeoisf heoifjh oi</div><br />(Date Posted)
                            <div id="tester">dadw</div>
                        </div>


                    </div>
                </div>

    </body>



    </html>
    <?php 
function CheckIfVoted($StaffId, $PostId, $link){
    $query = "SELECT * FROM Vote WHERE StaffID = $StaffId and PostID = $PostId";
    
    $result = mysqli_query($link, $query);
    if(mysqli_num_rows($result) > 0){
        return "secondary";
    }
    else{
        return "default";
    }
    
}
function SetStyle($styleToSet, $buttonType){
    if($styleToSet == "secondary"){
        return "secondary";
    }
    else{
        if($buttonType == "up"){
            return "success";
        }
        else{
            return "danger";
        }
        
        
    }
    }


?>
