<!DOCTYPE html>
<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();
require 'mysql.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />'); ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <form enctype="multipart/form-data" action="Uploadtest.php" method="POST">
        <div class="custom-file">
            <label for="img">Upload Image: </label>
            <div class="col-sm-12">
                Alternative Text: <input type="text" style="width:30%" class="form-control input-md" name="altText" />
                <input type="file" size="40" id="userFile" name="userFile" />
                <br><button type="submit">submit</button>
            </div>
        </div>
    </form>
</body>

</html>
<?php

    if($_FILES['userFile']['type']){
         if ( !preg_match( '/gif|png|x-png|jpeg|jpg|DOC|DOCX|PDF|doc|docx|pdf|/', $_FILES['userFile']['type']) ) {
   die('<p>Only browser compatible images allowed</p></body></html>');
} else if ( strlen($_POST['altText']) < 9 ) {
   die('<p>Please provide meaningful alternate text</p></body></html>');
} else if ( $_FILES['userFile']['size'] > 32000 ) {
   die('<p>Sorry file too large</p></body></html>');
// Connect to database
} else if ( !($link = mysqli_connect($host, $user, $passwd, $dbName)) ) {
   die('<p>Error connecting to database</p></body></html>');
// Copy image file into a variable
} else if ( !($handle = fopen ($_FILES['userFile']['tmp_name'], "r")) ) {
   die('<p>Error opening temp file</p></body></html>');
} else if ( !($image = fread ($handle, filesize($_FILES['userFile']['tmp_name']))) ) {
   die('<p>Error reading temp file</p></body></html>');
} else {
   fclose ($handle);
   // Commit image to the database
   $image = mysqli_real_escape_string($link, $image);
   $alt = htmlentities($_POST['altText']);
             $query = "INSERT INTO Upload(PostID, StaffID, Type, Name, Alt, Data) VALUES(1,1,'".$_FILES['userFile']['type']."','".$_FILES['userFile']['name']."','".$alt."','".$image."')";
            
             if(mysqli_query($link, $query)){
                 echo "uploaded";
             }
             
            }   } 
?>
    