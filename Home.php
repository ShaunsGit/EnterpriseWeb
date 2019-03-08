<!DOCTYPE html>
<!-- link to site: https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/Home.php -->
<?php  session_start(); 
require 'mysql.php';
//ini_set('display_errors',1);
//    error_reporting(E_ALL);
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');

?>
<html lang="en-GB">




<head>
    <title>Home Page</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Latest compiled and minified CSS -->
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
            font-size: 14px;
            color: black;
            max-height: 20px;
        }
        
        .card {
            width: 15rem;
            height: 15rem;
            border-style: solid;
            border-width: 1px;
            right: 13px;
            /*            background-color: #eaeaea;*/
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        
        .buttons {
            position: absolute;
            bottom: 0;
            padding-bottom: 13px;
            padding-top: 5px;
            color: white;
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
        
        .Posts {}
        
        .disabled {}

    </style>


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

        function DownVote(PostId){
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
    <img class="img1" alt="A screenshot showing CSS Quick Edit" style="" src="mainpic1.jpg">

    <div id="testing"></div>
    <br />



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

    <div id="Posts">


       
        <?php
    //Get the page number, if there isnt one then set it to 1
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    
    // Gets a specific 5 rows from the db depending on the page number.
    $no_of_records_per_page = 5;
    $offset = ($pageno-1) * $no_of_records_per_page; 
    
    $total_pages_sql = "SELECT COUNT(*) FROM Posts";
    $result = mysqli_query($link,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
 
    
    // Getting the post info (with inner join to show departments)
    $query = "SELECT PostID, Title, Posts.DepartmentID, Department.Department,      Description, Up_Vote, Down_Vote, Date_Posted from Posts
    INNER JOIN Department
    ON Posts.DepartmentID = Department.DepartmentID
    ORDER BY PostID DESC LIMIT $offset, $no_of_records_per_page";
    
        
    // Execute query and store the posts
    $posts = mysqli_query($link, $query);
        
    // Interate through the results whiles echoing the DIVs.
    if(mysqli_num_rows($posts) > 0){
        $counter = 0;
        while($row = mysqli_fetch_assoc($posts)) {
       /* echo  "<div id=".$counter."><a href=" ."Post.php?PostID=" .$row["PostID"]. "><h3><u>Post ".$counter."</u></h3> 
        PostID: " . $row["PostID"] . "<br />
        StaffID: " . $row["StaffID"] . "<br />
        CategoryID:" . $row["CategoryID"] . "<br />
        DepartmentID:" . $row["DepartmentID"] . "<br />
        UploadID:" . $row["UploadID"] . "<br />
        Title:" . $row["Title"] . "<br />
        Description:" . $row["Description"] . "<br />
        Date_Posted:" . $row["Date_Posted"] . "<br />
        Up_Vote:" . $row["Up_Vote"] . "<br />
        Down_Vote:" . $row["Down_Vote"] . "<br /></a></div>";
        $counter++;*/
            //check to see if user has voted for the post and set style variable.
            $style = CheckIfVoted($_SESSION['UID'], $row['PostID'], $link);
            
            if($counter == 0 or $counter == 3){              
             $date = $row["Date_Posted"];
             $newDate = date("d-m-Y", strtotime($date));
             $stringLimit = 100;
                

                
                //Displays the top left card, and bottom left.
               echo '
                   <div class="container-fluid" style="">
            <div class="row" style="margin-top:15px">
            <div class="col-sm-4" >
                <div class="card">
                    <a href="Post.php?PostID='.$row['PostID'].'"><div class="card-body">
                        <h5 class="card-title">'.$row["Title"].'</h5>
                        <h6 class="card-subtitle mb-2 text-muted">'. $row["Department"] .'</h6>

                        <p class="card-text">'. substr($row["Description"], 0 , $stringLimit).'...</p>
                        <div class="buttons">
                            <a onclick="UpVote('.$row['PostID'].')" id="likeBtn-'.$row['PostID'].'" class="btn btn-'.SetStyle($style, "up").' btn-sm">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Up '.$row["Up_Vote"].'
                            </a>
                            <a onclick="DownVote('.$row['PostID'].')" id="dislikeBtn-'.$row['PostID'].'" class="btn btn-'.SetStyle($style, "down").' btn-sm">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Down '.$row["Down_Vote"].'
                            </a> <a id="date" class="date">'.$newDate.'</a>
                        </div>
                    </div></a>
                </div>
            </div>';
            }
            if($counter == 0 or $counter == 3){
               // Empty space top middle.  and bottom.
                echo '  <div class="col-sm-4" > </div>';
            }
            if($counter == 1 or $counter == 4){
            //top right and end line. bottom right and end line.
                echo ' <div class="col-sm-4" >
                <div class="card">
                   <a href="Post.php?PostID='.$row['PostID'].'"><div class="card-body">
                    <h5 class="card-title">'.$row["Title"].'</h5>
                <h6 class="card-subtitle mb-2 text-muted">'. $row["Department"] .'</h6>


                          <p class="card-text">'. substr($row["Description"], 0 , $stringLimit).'...</p>
                        <div class="buttons">
                         <a onclick="UpVote('.$row['PostID'].')"  id="likeBtn-'.$row['PostID'].'" class="btn btn-'.SetStyle($style, "up").' btn-sm">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Up '.$row["Up_Vote"].'
                            </a>
                               <a onclick="DownVote('.$row['PostID'].')" id="dislikeBtn-'.$row['PostID'].'" class="btn btn-'.SetStyle($style, "down").' btn-sm" >
                                <span class="glyphicon glyphicon-thumbs-up"></span> Down '.$row["Down_Vote"].'
                            </a> <a id="date" class="date">'.$newDate.'</div>
                        </div>
                    </div></a>
                   </div>
        </div>
        </div></div>';
            }
            
            if($counter == 2){
                // Start new line, empty space middle left, displays middle card, empty space on the middle right and end the line.
                echo'
            <div class="container-fluid">
                <div class="row" style="margin-top:15px">
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <a href="Post.php?PostID='.$row['PostID'].'">
                                <div class="card-body">
                                    <h5 class="card-title">'.$row["Title"].'</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">'. $row["Department"] .'</h6>

                                    <p class="card-text">' . substr($row["Description"], 0 , $stringLimit) . '...</p>
                                    <div class="buttons">
                                        <a onclick="UpVote('.$row['PostID'].')" id="likeBtn-'.$row['PostID'].'" class="btn btn-'.SetStyle($style, "up").' btn-sm">
                                            <span class="glyphicon glyphicon-thumbs-up"></span> Up '.$row["Up_Vote"].'</a>
                                        <a onclick="DownVote('.$row['PostID'].')" id="dislikeBtn-'.$row['PostID'].'" class="btn btn-'.SetStyle($style, "down").' btn-sm">
                                            <span class="glyphicon glyphicon-thumbs-up"></span> Down '.$row["Down_Vote"].'
                                        </a> <a id="date" class="date">'.$newDate.'</div>
                        </div>
                    </div></a>
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                </div>
                        </div>
                    </div>
                    '; 
            } 
            $counter++; 
        } 
    } ?>
    </div>

    <ul class="pagination" style="width:100%">
        <div id="pagButtons" class="pagButtons">
            <li><a href="?pageno=1">First</a></li>
            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo " ?pageno=".($pageno - 1); } ?>">Prev</a>
            </li>
            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo " ?pageno=".($pageno + 1); } ?>">Next</a>
            </li>
            <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
        </div>
    </ul>


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