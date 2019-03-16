<!DOCTYPE html>
<!--link to site: https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/Register.php -->




<?php
//Uploads the data sent from Reister.html to the Staff table in the database.
session_start();
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');

setcookie("email", "", time() + (86400 * 30), "/");
?>


    <html lang="en-GB">

    <head>
        <title>Register</title>
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


<style>table {
            border-radius: 6px;
            -moz-border-radius: 6px;
        }</style>
      
    </head>

    <body>
        <img class="img1" alt="A screenshot showing CSS Quick Edit" src="mainpic1.jpg">


        <div class="topnav" id="myTopnav">
                <a href="Home.php">Home</a>
                <a href="">Search Idea</a>
                <a style="float:right" href="Register.php" class="active">Register</a>
                <a style="float:right" href="Login.html">Sign In</a>
                <a href="javascript:void(0);" class="icon" onclick="responsive()">
                    <i class="fa fa-bars"> </i>
                </a>
        </div>
        <!-- Registration Form -->
        <form action="RegisterAuth.php" method="post">
            <table width="495" height="232" border="0">
                <tr>

                    <td><label for="name">Name:</label> </td>
                    <td>
                        <div class="form-group">
                            <input id="name" size="25" name="name" type="text" placeholder="Enter Name (Case Sensitive.)" class="form-control textField form-control-sm shadow">
                        </div>
                    </td>

                </tr>
                <tr>

                    <td><label for="email">Email:</label> </td>
                    <td>
                        <div class="form-group">
                            <input id="email" size="25" name="email" type="email" placeholder="Enter Email (Case Sensitive.)" class="form-control textField form-control-sm shadow">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Department</td>

                    <td>

                        <select class="form-control form-control-sm textField" name="department">

                <?php 
                //Calls the function to display departments
                DepartmentDropDown($link);
                ?> 
            </select>

                    </td>
                </tr>

                <tr>
                    <td> <label for="pass">Password</label> </td>
                    <td>
                        <div class="form-group">
                            <input id="password" size="25" name="pass" type="password" class="form-control textField form-control-sm shadow" placeholder="Enter Password">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="pass">Confirm Password:</label> </td>
                    <td>
                        <div class="form-group">
                            <input id="confirmPassword" size="25" name="confirmPass" type="password" class="form-control textField form-control-sm shadow" placeholder="Type password again">
                        </div>
                    </td>
                </tr>


                <td>
                    <button type="submit" name="registerbtn" id="register" class="button">Register</button>
                </td><td></td>
            </table>
        </form>



        <br />

        <!--Return the user to the login page -->

        <form action="Login.html" method="post">
            
                <button type="submit" name="backToLogin" id="backToLogin" class="buttonRed">Back to Login</button>
        


        </form>
          <script>

              
              function responsive() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            }


           
            $("form").submit(function(e) {
                  
                var validationFailed = false;
                // do your validation here ...
                var password = $('#password');
                var conPassword = $('#confirmPassword');
                if(password.val() == conPassword.val()){
                    return true;
                }
                
                if (validationFailed) {
                  e.preventDefault();
                    conPassword.addClass("err");
                    return false;
                }
            });
      
        </script>
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
