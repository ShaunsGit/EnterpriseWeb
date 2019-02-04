<!DOCTYPE html>
<!--link to site: https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/Register.php -->
<?php
//Uploads the data sent from Reister.html to the Staff table in the database.
session_start();
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');
?>


    <html lang="en-GB">

    <head>
        <title>Register</title>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">

        <link href="mainstyle.css" rel="stylesheet" />

    </head>

    <body>
        <!-- Registration Form -->
        <form action="RegisterAuth.php" method="post">
            Name: <input id="name" name="name" type="text" placeholder="Enter Name (Case Sensitive.)">
            <br /> Email: <input id="email" name="email" type="text" placeholder="Enter Email (Case Sensitive.)" >
            <br /> Department

            <select name="department">
                <?php 
                //Calls the function to display departments
                DepartmentDropDown($link);
                ?> 
            </select>
            <br /> Enter Password: <input id="password" name="pass" type="password"> Confirm Password: <input id="confirmPassword" name="confirmPass" type="password">

            <br />
            <button type="submit" name="registerbtn" id="register" class="">Register</button>
        </form>
        <br />

        <!--Return the user to the login page -->
        <form action="Index.html" method="post">
            <button type="submit" name="backToLogin" id="backToLogin" class="">Back to Login</button>
        </form>
    </body>

    </html>




    <?php 

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



?>
