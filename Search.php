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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .card-text {
            font-size: 14px;
            color: white;
            max-height: 20px;
        }
        
        .card {
            width: 15rem;
            height: 15rem;
            border-style: solid;
            border-width: 1px;
            right: 13px;
            background-color: #093145;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        
        .card-body {
            color: #EFD469;
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
            color: #EFD469;
        }
        
        .Posts {}
        
        .disabled {
            visibility: hidden;
        }

    </style>


    <script>
        function responsive() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }

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
    <img class="img1" alt="A screenshot showing CSS Quick Edit" style="" src="mainpic1.jpg">

    <div id="testing"></div>
    <br />



    <div class="topnav" id="myTopnav">
        <a href="Home.php">Home</a>
        <a href="">Search Idea</a>
        <?php

            if($_SESSION['loggedIn'] == true){
                    echo '<a style="float:right" href="Logout.php">Logout</a>';
            }else {
                echo '

                <a style="float:right" href="Register.php">Register</a>
                <a style="float:right" href="Login.html">Sign In</a>
                ';
            }  
            if($_SESSION['loggedIn'] == true)
            {
                echo '
                <a href="MyIdeas.php">My Ideas</a>
                <a href="IdeaSubmission.php">Add Ideas</a>' ;
            }
            if($_SESSION['role'] == "Admin" or $_SESSION['role'] == "QAmanager")
            {
                echo '
                <a href="Management/login.php" class="green">Management</a>' ;
            }
            ?>
            <a href="javascript:void(0);" class="icon" onclick="responsive()">
                <i class="fa fa-bars"> </i>
            </a>
    </div>
    <br/>
    <div id="search" class="searchArea">
        <!--
        <table class="table ">
            <tbody>
                <tr>
                    <th scope="row">Search:</th>
                    <td> <input id="searchInput" size="50" name="search" type="text" placeholder="Search ideas." class="form-control form-control-sm shadow"> </td>

                </tr>
                <tr>
                    <th scope="row">Filter:</th>
                   <td>  <input type="checkbox" name="vehicle" value="Bike"> Post title</td>

                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td colspan="2">Larry the Bird</td>

                </tr>
            </tbody>
        </table>
-->
        <form action="Search.php" action="get">
            <div>
                Search
                <br />
                <input id="searchInput" size="50" name="search" type="text" placeholder="Search ideas." class="form-control form-control shadow">
                <br/>
                <a class="btn btn-outline-info btn-sm" data-toggle="collapse" href="#filtersCol" role="button" aria-expanded="false" aria-controls="filtersCol">Show Filters</a>

                <div class="row">
                    <div class="col">
                        <div class="collapse multi-collapse" id="filtersCol">
                            <div class="col-sm">
                                Department:
                                <select class="form-control form-control textField" name="department">
                                <option value="all">View All</option>
                            <?php DepartmentDropDown($link); ?>
                            </select>

                            </div>
                            <div class="col-sm">

                                Category:
                                <select class="form-control form-control textField" name="category">
                                  <option value="all">View All</option>
                            <?php CategoryDropDown($link); ?>
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="searchBtn">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <br />
            </div>
        </form>
    </div>



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
    $query = "SELECT PostID, Title, Posts.DepartmentID, Department.Department,   Description, Up_Vote, Down_Vote, Date_Posted from Posts INNER JOIN Department ON Posts.DepartmentID = Department.DepartmentID ";
    
    $innerjoin = "ORDER BY PostID DESC LIMIT $offset, $no_of_records_per_page";
        
    if(isset($_GET['search']) || isset($_GET['category']) || isset($_GET['department']) ){
        extract($_GET);
        
        if($search == "" && $department == "all" && $category == "all" ){
             $query = "SELECT PostID, Title, Posts.DepartmentID, Department.Department,   Description, Up_Vote, Down_Vote, Date_Posted from Posts INNER JOIN Department ON Posts.DepartmentID = Department.DepartmentID ";
    
    $innerjoin = "ORDER BY PostID DESC LIMIT $offset, $no_of_records_per_page";
 
        } 
        if($search != ""){
            $query .= "Where Posts.Title or Posts.Description LIKE '%$search%' ";
//            echo $query;
        }
        if($department != "all"){
             if($search == ""){
                 $query .= "where Posts.DepartmentID = $department ";
             }else{
                $query .= "and Posts.DepartmentID = $department ";
             }
        }
        if($category != "all"){
             if($search == "" && $department == "all"){
                 $query .= "where Posts.CategoryID = $category ";
             }else{
                $query .= "and Posts.CategoryID = $category ";
             }
        }
    }    

    // Execute query and store the posts
    $posts = mysqli_query($link, $query.$innerjoin);
        
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

                        <h5 class="card-title" style="color: #EFD469" >'.$row["Title"].'</h5>
                        <h6 class="card-subtitle" style="color: white">'. $row["Department"] .'</h6>


                        <p class="card-text">'. substr($row["Description"], 0 , $stringLimit).'</p>
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

                   <a href="Post.php?PostID='.$row['PostID'].'"><div class="card-body ">
                    <h5 class="card-title" style="color: #EFD469">'.$row["Title"].'</h5>
                <h6 class="card-subtitle" style="color: white">'. $row["Department"] .'</h6>



                          <p class="card-text">'. substr($row["Description"], 0 , $stringLimit).'</p>
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

                                    <h5 class="card-title" style="color: #EFD469">'.$row["Title"].'</h5>
                                    <h6 class="card-subtitle" style="color: white">'. $row["Department"] .'</h6>


                                    <p class="card-text">' . substr($row["Description"], 0 , $stringLimit) . '</p>
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
    }else{
        echo "no posts found";
    } ?>
    </div>

    <ul class="pagination" style="width:100%">
        <?php 
            if($_SESSION['loggedIn'] == true)
            {?>
        <span style=" position: absolute;font-size:12px; color:grey; float:left">
                 <div>Last Logged:<?php echo $_SESSION['lastLogged']; ?></div>

        <div>Post Count: <?php echo $_SESSION['postCount'];?> (All time)</div>

        <div></div></span>
        <?php }
            ?>
        <div id="pagButtons" class="pagButtons">

            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>"><a href="?pageno=1">First</a></li>
            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo " ?pageno=".($pageno - 1); } ?>">Prev</a>
            </li>
            <li>
                <a>
                    <?php echo $pageno."/".$total_pages ?>
                </a>
            </li>
            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo " ?pageno=".($pageno + 1); } ?>">Next</a>
            </li>
            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
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
    
    
function DepartmentDropDown($link){
       /*Pulls the departments from the department table and displays it as a
                drop down list */
                
                $query = "SELECT * FROM Department";
                $result = mysqli_query($link, $query);
                    
                if (mysqli_num_rows($result)){
                    while($row = mysqli_fetch_assoc($result)) {
                        echo ' <option  value=' . $row["DepartmentID"] . '>' . $row["Department"] . '</option>';
                        
                    }
                } else {
                    echo "No results.";
                }
}

    function CategoryDropDown($link){
        /*Pulls the departments from the department table and displays it as a
        drop down list */
        
        $query = "SELECT * FROM Category";
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)) {
                echo ' <option  value=' . (int)$row["CategoryID"]  . '>' . $row["Category"] .         '</option>';
                        
            }
        } else {
            echo "No results.";
        }
    }

?>
