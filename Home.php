<!DOCTYPE html>
<?php  session_start(); 
if(!$_SESSION){
    header("location: Login.php");
}
//dummy data
$post = array(
array("ID = 1" , "Title", "Description"),
array("ID = 2", "Title", "Description"),
array("ID = 3", "Title", "Description"),
);

?>
<html lang="en-GB">

<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="mainstyle.css" rel="stylesheet" />
</head>

<body>
    <h1>Home Page</h1>


    <br />

    <?php   
    //Uses the session to get the users name from the DB
    echo "Welcome " . $_SESSION["Name"] . " <br />";
    echo "SESSION  ";
    print_r($_SESSION);?>
<br />
<br />
<br />
    <u>These posts are not from a DB</u> 
<br />
<?php 
    
    //lists the fake array of post (will have post from db)
    for($i=0; $i< count($post); $i++)
    {
        for($n = 0; $n < count($post[0]); $n++){
            echo $post[$i][$n] . ", ";
        }
        echo "<br / >";
    }
    

    ?>
    
    
    <br />
    <br />
    <br />
    <br />
   
</body>

</html>
