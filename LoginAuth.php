

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


$query = "SELECT Name, Password, Staff.DepartmentID, Staff.RoleID, Department.Department, Roles.Roles FROM Staff
INNER JOIN Department on Staff.DepartmentID = Department.DepartmentID 
inner join Roles on Staff.RoleID = Roles.RoleID WHERE Email = '$email'";
$result = mysqli_query($link, $query);
if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_assoc($result);
                $hash = $row['Password'];
                $dbDepartment = $row['Department'];
                $dbRole = $row['Roles'];
                $name = $row['Name'];
                if(password_verify($pass, $hash)){
                    $_SESSION["role"] = "$dbRole";
                    $_SESSION["department"] = "$dbDepartment";
                    $_SESSION["Name"] = "$name"; 
                    echo $dbDepartment ."    " . $dbRole;
                    header("location: Home.php");
                }else{
                    echo "Password Does not match.";
                }
}else{
    echo 'Email does not exsist.
     <form action="Index.html" method="post">
            <button type="submit" name="backToLogin" id="backToLogin" class="">Back to Login</button>
        </form>
    ';
    
}

?>
