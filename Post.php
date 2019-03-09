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


        <script>
            // downvote function check to see if the user has voted and puts through the vote if they havent
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

            // upvote function check to see if the user has voted and puts through the vote if they havent
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

            //when the user clicks cubmit comment it is validated, uploaded to the db and the comments get refreshed. (updates live)
            function SubmitComment(PostID) {
                var comment = $("#comment").val();
                var comLength = comment.length;
                var isValid = Validate(comment);


                if (isValid == "e" || isValid == "m") {
                    //error if empty or exceeds maximum 
                    $("#comment").css("background-color", "red");

                    if (isValid == "e") {
                        alert("The Comment can not be empty.\nInvalid input.");
                    }

                    if (isValid == "m") {
                        alert(" Maximum numbers of characters exceeded. (max 255).\nCurrent length: " + comLength + " chars\nInvalid input.");
                    }



                } else {
                    $("#comment").css("background-color", "white");
                    var comment = isValid;

                    var uploadComment = new XMLHttpRequest();
                    uploadComment.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = this.responseText;
                            var response = response.substr(267);

                            console.log("1: " + response);
                            LoadComments(PostID);



                        }

                    };
                    uploadComment.open("POST", "Comment.php", true);
                    uploadComment.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    uploadComment.send("postID=" + PostID + "&com=" + comment + "&userID=" + <?php echo $_SESSION['UID']; ?>);


                }
            }

            // gets all comments for the specific post. 
            function LoadComments(PostID) {
                $("#comments").html("");


                var getComments = new XMLHttpRequest();
                getComments.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = this.responseText;
                        var response = response.substr(267);
                        console.log(response);
                        $('#comment').val("");
                        $('#comments').append(response);
                        <?php if($_SESSION['role']== "Admin"){ ?>
                        $('.comment').removeAttr("hidden");
                        <?php } ?>

                    }

                };
                getComments.open("GET", "getComment.php?postID=" + PostID, true);
                getComments.send();
            }



            //validates the users input.
            function Validate(com) {
                var rgx = /[<>]/;
                var length = com.length;
                var err;
                if (length > 256) {

                    console.log("input is too large (max 256char)");
                    return "m"; //max input

                } else if (length == 0) {

                    console.log("input is empty");
                    return "e"; //empty input
                } else {
                    com = com.replace(/[ \t]{2,}/gm, "");
                    console.log("Valid Input");
                    return com; //valid string
                }
            }
            //edit function is for the moderators to change the posts data.
            function Edit() {
                $("#delete").removeAttr("hidden");
                $("#ADMIN").attr("onclick", "DoneEdit()");
                $("#ADMIN").html("Save Changes");
                $("#report").attr("hidden", "true");

                var titleEle = $("#postTitle");
                var categoryEle = $("#postCategory");
                var descEle = $("#postDesc");
                var title = titleEle.text();
                var category = categoryEle.text();
                var desc = descEle.text();
                // console.log(title + " " + category + " " + desc);

                titleEle.html("");
                titleEle.append('<input type="text" id="alterTitle" value="' + title + '">');
                descEle.html("");
                descEle.append('<textarea rows="2" id="alterDesc" cols="30">' + desc.substr(33) + '</textarea>');
                categoryEle.html("");
                categoryEle.append(' <select id="alterCate" name="category">');
                $("#alterCate").append("<?php CategoryDropDown($link) ?>");
            }
            // updates the database when the moderator has finished editing.
            function DoneEdit() {

                $("#ADMIN").attr("onclick", "Edit()");
                $("#ADMIN").html("Edit");
                $("#report").removeAttr("hidden");
                $("#delete").attr("hidden", "true");

                var titleEle = $("#alterTitle");
                var categoryEle = $("#alterCate");
                var descEle = $("#alterDesc");
                var title = titleEle.val();
                var category = categoryEle.val();
                var desc = descEle.val();
                // console.log(title + " " + category + " " + desc);


                var doneEdit = new XMLHttpRequest();
                doneEdit.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = this.responseText.substr(267);
                        console.log(response);
                        $("#postTitle").html("");
                        $("#postTitle").append('<h5 class="card-title" style="color: #EFD469" id="postTitle">' + title + '</h5>');
                        var dropDownTxt = $("#alterCate option:selected").text();
                        $("#postCategory").html("");
                        $("#postCategory").append(' <div class="card-text" style="text-align: center" id="postCategory">' + dropDownTxt + '</div>');
                        $("#postDesc").html("");
                        $("#postDesc").append('<div class="card-text" id="postDesc">' + desc + '</div>');

                    }

                };
                doneEdit.open("POST", "EditPost.php", true);
                doneEdit.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                doneEdit.send("postID=<?php echo $_GET["
                    PostID "]; ?>&title=" + title + "&cate=" + category + "&desc=" + desc);
            }

            function DeletePost(PostID) {
                if (confirm("Are you sure you want to delete this post?")) {
                    var deletePost = new XMLHttpRequest();
                    deletePost.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = this.responseText;
                            var response = response.substr(267);
                            
                            window.location.replace("Home.php");
                            console.log(response);

                        }

                    };
                    deletePost.open("GET", "deletePost.php?postID=" + PostID, true);
                    deletePost.send();
            }}

        </script>
    </head>

    <body onload="LoadComments(<?php echo $_GET['PostID']; ?>)">
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
            $staffId = $row['StaffID'];
        }
        
    $date = date("d-m-Y", strtotime($date));
        
    }else{
        echo "Post does not exsist.";
        echo $query;
    }  ?>
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

                        <h5 class="card-title" style="color: #EFD469" id="postTitle"><?php echo $title; ?></h5>
                        <h6 class="card-subtitle" style="color: white"><?php echo $department; ?></h6>
                        <p><br></p>
                        <div>

                            <div style="text-align: center"><u>Category</u></div>
                            <div class="card-text" style="text-align: center" id="postCategory">
                                <?php  echo $category; ?>
                            </div>

                            <p><br></p>

                            <div style="text-slign:left"><u>Description</u></div>
                            <div class="card-text" id="postDesc">
                                <?php  echo $desc; ?>
                            </div>

                            <p><br></p>
                            <p><br></p>

                            <div style="text-slign:left"><u>Date</u></div>
                            <div class="card-text" id="postDate">
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
                                <a onclick="UpVote(<?php echo $_GET['PostID'];?>)" id="likeBtn-<?php echo $_GET['PostID']; ?>" class="btn btn-<?php echo SetStyle($style, " up ");?> btn-sm">
                                   Up
                                    <?php echo $upVote; ?>
                                </a>
                                <a onclick="DownVote(<?php echo $_GET['PostID']; ?>)" id="dislikeBtn-<?php echo $_GET['PostID']; ?>" class="btn btn-<?php echo SetStyle($style, " down "); ?> btn-sm">
                                     Down
                                    <?php echo $downVote; ?>
                                </a>
                                <?php //Only shows the edit button for Admin, WAmanager and the coord only if the post is under their department. 
                                //also if it is the users own post, they can edit
                                if($_SESSION['role'] == "Admin"||$_SESSION['role'] == "QAmanager" || $_SESSION['role'] == "QAcoord" && $_SESSION['department'] == $department || $_SESSION['UID'] == $staffId){ ?>
                                <a id="ADMIN" onclick="Edit()" class="btn btn-primary btn-sm right">
                                     Edit
                                </a>

                                <?php } ?>

                                <a id="report" class="btn btn-outline-warning btn-sm right">
                                     Report
                                </a>
                                <a id="delete" hidden="true" onclick="DeletePost(<?php echo $_GET['PostID'] ?>)" class="btn btn-outline-danger btn-sm right">
                                     Delete
                                </a>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

            <hr />
            <h5 style="text-align:left">Insert your Comments</h5>
            <textarea name="message" id="comment" rows="4" placeholder="Insert comment."></textarea>
            <div> <button class="button" style="float:right" onclick="SubmitComment(<?php  echo $_GET['PostID']?>)" role="button">Submit Comment</button>
                <br /><br />



                <h5 style="text-align:left">All Comments</h5>




                <div id="comments">

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
                          
    function CategoryDropDown($link){
        /*Pulls the departments from the department table and displays it as a
        drop down list */
        
        $query = "SELECT * FROM Category";
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)) {
                echo ' <option  value=' . $row["CategoryID"] . '>' . $row["Category"] .         '</option>';
                        
            }
        } else {
            echo "No results.";
        }
    }


                          
                          
                          
?>
