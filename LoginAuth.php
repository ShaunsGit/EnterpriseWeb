<a href="mainpic.jpg">
    <img class="img1" alt="A screenshot showing CSS Quick Edit" src="mainpic1.jpg">
</a>

<html lang="en-GB">

<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>
        function responsive() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }

    </script>

</head>

<body>
   

    <div class="topnav" id="myTopnav">
        <a href="Home.php">Home</a>
        <a href="">Search Idea</a>
        <a href="IdeaSubmission.html">Add Ideas</a>
        <a style="float:right" href="Register.php">Register</a>
        <a style="float:right" href="Login.html">Sign In</a>
        <a href="javascript:void(0);" class="icon" onclick="responsive()">
            <i class="fa fa-bars"> </i>
        </a>
    </div>


</body>

</html>


<?php

session_start();
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');
// remove all session variables
session_unset(); 


// Validate input
// Check to see if the user exsists
// Compare the entered password to the stored one
// Allow if password is correct
// Deny if the password is incorrect
// Needs to update the Last_Logged column in the DB

$email = $_POST['email'];
$pass = $_POST['password'];
$setCookie = $_POST['rememberMe'];

$query = "SELECT StaffID, Name, Password, Staff.DepartmentID, Staff.RoleID, Department.Department, Roles.Roles, Last_Logged, Post_Count FROM Staff
INNER JOIN Department on Staff.DepartmentID = Department.DepartmentID 
inner join Roles on Staff.RoleID = Roles.RoleID WHERE Email = '$email'";
$result = mysqli_query($link, $query);
    if(mysqli_num_rows($result) > 0)
    {
        if($setCookie == 1){
            setcookie("email", $email, time() + (86400 * 30), "/"); // 86400 = 1 day
        }else{
            setcookie("email", "", time() + (86400 * 30), "/"); // 86400 = 1 day
        }
        $row = mysqli_fetch_assoc($result);
        $hash = $row['Password'];
        $dbDepartment = $row['Department'];
        $dbDepartmentID = $row['DepartmentID'];
        $dbRole = $row['Roles'];
        $name = $row['Name'];
        $UID = $row['StaffID'];
        $lastLogged = $row['Last_Logged'];
        $postCount = $row['Post_Count'];
        if(password_verify($pass, $hash)){
            $_SESSION["role"] = "$dbRole";
            $_SESSION["department"] = "$dbDepartment";
            $_SESSION["Name"] = "$name";
            $_SESSION['UID'] = $UID;
            $_SESSION['loggedIn'] = true;
            $_SESSION['departmentID'] = $dbDepartmentID;
            $_SESSION['lastLogged'] = $lastLogged;
            $_SESSION['postCount'] = $postCount;
            
            echo $dbDepartment ."    " . $dbRole;
            $query = "Update Staff SET Last_Logged='" . date("Y/m/d") . "'WHERE      StaffID=" . $UID;
                    mysqli_query($link, $query);
                    header("location: Home.php");
                }else{
                    echo "Incorrect Password";
                }
}else{
    echo 'Email does not exsist.

     <form action="Login.html" method="post">
            <button type="submit" name="backToLogin" id="backToLogin" class="buttonRed">Back to Login</button>


    ';
    
}

?>
