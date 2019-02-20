<!DOCTYPE html>
<!--link to site: https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/Register.php -->
<a href="mainpic.jpg">
    <img class="img1" alt="A screenshot showing CSS Quick Edit" src="mainpic.jpg">
</a>

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


        <link href="main.css" rel="stylesheet" />

    
        

    </head>

    <body>

        <ul>
            <li>
            <a href="Home.php">Home</a></li>
        <li style="float:right">
            <a href="Register.php">Register</a></li>
        <li style="float:right">
            <a href="Login.html">Sign In</a></li>
            <li>
                <a href="">Search Idea</a></li>
        </ul>
        <!-- Registration Form -->
        <form action="RegisterAuth.php" method="post">
            <table width="495" height="232" border="0">
                <tr>
                    <td>Name: </td>
                    <td><input id="name" size="25" name="name" type="text" placeholder="Enter Name (Case Sensitive.)"></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td><input id="email" size="25" name="email" type="text" placeholder="Enter Email (Case Sensitive.)"></td>
                </tr>

                <tr>
                    <td>Department</td>

                    <td>

            <select name="department">

                <?php 
                //Calls the function to display departments
                DepartmentDropDown($link);
                ?> 
            </select>

                    </td>
                </tr>

                <tr>
                    <td>Enter Password: </td>
                    <td>
                        <input id="password" size="25" name="pass" type="password"> </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td><input id="confirmPassword" size="25" name="confirmPass" type="password"></td>
                </tr>

            
                <td>
                    <button type="submit" name="registerbtn" id="register" class="button">Register</button>
                </td>
                     </table>
                </form>
       

          
        <br />

        <!--Return the user to the login page -->

        <form action="Login.html" method="post">
            <td>
                <button type="submit" name="backToLogin" id="backToLogin" class="buttonRed">Back to Login</button>
            </td>


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
