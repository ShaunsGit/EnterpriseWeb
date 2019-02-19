<!DOCTYPE html>
<?php  session_start(); 
require 'mysql.php';
//ini_set('display_errors',1);
//    error_reporting(E_ALL);
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');

?>
<html lang="en-GB">

<img class="img1" alt="A screenshot showing CSS Quick Edit" src="mainpic.jpg">


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
</head>

<body>
    <h1>Home Page</h1>


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
    <?php
//    
//    //lists the fake array of post (will have post from db)
//    for($i=0; $i< count($post); $i++)
//    {
//        for($n = 0; $n < count($post[0]); $n++){
//            echo $post[$i][$n] . ", ";
//        }
//        echo "<br / >";
//    }
    
    
    //--------------------------------------------------------------------------------

    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    
    $no_of_records_per_page = 5;
    $offset = ($pageno-1) * $no_of_records_per_page; 
    
    $total_pages_sql = "SELECT COUNT(*) FROM Posts";
    $result = mysqli_query($link,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    //echo "Total Pages". $total_pages;
    
    //--------------------------------------------------------------------------------
    
    $query = "SELECT * from Posts LIMIT  $offset, $no_of_records_per_page";
    $posts = mysqli_query($link, $query);
    
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
            
            if($counter == 0 or $counter == 3){
              
              
               echo '
                   <div class="container-fluid" style="">
        
        <div class="row">
            <div class="col-sm-4" >
                <div class="card" style="width: 15rem;height:15rem; border-style:solid; border-width:1px; right:13px">
                    <a href="Post?PostID='.$row['PostID'].'"><div class="card-body">
                        <h5 class="card-title">'.$row["Title"].'</h5>
                        <h6 class="card-subtitle mb-2 text-muted">'. $row["DepartmentID"] .'</h6>

                        <p class="card-text" style="max-height:20px;">'. substr($row["Description"], 0 , 100).'...</p>
                        <div class="buttons" style="position: absolute; bottom: 0; padding-bottom:13px">
                            <a href="#" class="btn btn-success btn-sm">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Like '.$row["Up_Vote"].'
                            </a>
                            <a href="#" class="btn btn-danger btn-sm" style="position:relative; ">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Disike '.$row["Down_Vote"].'
                            </a>
                        </div>
                    </div></a>
                </div>
            </div>';
            }
            if($counter == 0 or $counter == 3){
               
                echo '  <div class="col-sm-4" > </div>';
            }
            if($counter == 1 or $counter == 4){
            
                echo ' <div class="col-sm-4" >
                <div class="card" style="width: 15rem;height:15rem; border-style:solid; border-     width:1px; right:13px">
                   <a href="Post?PostID='.$row['PostID'].'"><div class="card-body">
                    <h5 class="card-title">'.$row["Title"].'</h5>
                <h6 class="card-subtitle mb-2 text-muted">'. $row["DepartmentID"] .'</h6>


                          <p class="card-text" style="max-height:20px;">'. substr($row["Description"], 0 , 100).'...</p>
                        <div class="buttons" style="position: absolute; bottom: 0; padding-bottom:13px">
                         <a href="#" class="btn btn-success btn-sm">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Like '.$row["Up_Vote"].'
                            </a>
                               <a href="#" class="btn btn-danger btn-sm" style="position:relative; ">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Disike '.$row["Down_Vote"].'
                            </a>
                        </div>
                    </div></a>
                   </div>
        </div>
        </div></div>';
            }
            if($counter == 2){
                echo '    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4" >
                <div class="card" style="width: 15rem;height:15rem; border-style:solid; border-width:1px; right:13px">
                  <a href="Post?PostID='.$row['PostID'].'"> <div class="card-body">
                          <h5 class="card-title">'.$row["Title"].'</h5>
                           <h6 class="card-subtitle mb-2 text-muted">'. $row["DepartmentID"] .'</h6>

                        <p class="card-text" style="max-height:20px;">' . substr($row["Description"], 0 , 100) . '...</p>
                        <div class="buttons" style="position: absolute; bottom: 0; padding-bottom:13px">
                                                   <a href="#" class="btn btn-success btn-sm">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Like '.$row["Up_Vote"].'
                            </a>
                            <a href="#" class="btn btn-danger btn-sm" style="position:relative; ">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Disike '.$row["Down_Vote"].'
                            </a>
                        </div>
                    </div></a>
                </div>
            </div>
            <div class="col-sm-4" >

            </div>
        </div>
    </div>
';
            }
            
            $counter++;
        }
    }
    
    
    ?>

        <ul class="pagination" style="width:100%">
            <div id="pagButtons" style="position:relative; left: 250px">
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





?>
