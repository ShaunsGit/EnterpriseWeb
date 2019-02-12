<?php
//Uploads the data sent from Reister.html to the Staff table in the database.
session_start();
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');



//validate all inputs (needed)
//--must be unique email.
//--Password must match
//-- none of the fields can be empty
//then upload to the database.



extract($_POST);
/*Variables: 
    $email
    $confirmPass
    $pass
    $department
    $name
*/  
$valid;
if ( !preg_match('/^([\w\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/', $email) )
{
    $valid .= "Please Enter a Valid Email <br />";
}
if ( preg_match('/[^a-zA-Z]|^$/', $name) )
{
    $valid .= "Please Enter a Valid Name (First Name Only). <br />";
}
if ($valid == ""){
    if (isEmailAvailable($email, $link)){
        // Call the isEmailAvailable functions to see if email is available.
        if($confirmPass == $pass){
            // Check if both password match
            $hash = password_hash($pass, PASSWORD_DEFAULT); // Hashes the password.
            $query = "INSERT INTO Staff (DepartmentID, RoleID, Email, Name, Password, Date_Joined, Last_Logged, Post_Count, Comment_Count) Values('$department', 1, '$email', '$name', '$hash','" . date("Y/m/d") . "' ,'" . date("Y/m/d") . "', 0, 0)";
    
            if (mysqli_query($link, $query))
            {   // Uploads the data to the Database.
                
                header("location: Index.html");
                echo "<br />Data added";
            }
        } else {
            echo "<br />Password was not the same";
        }
    }s
    else{
        echo "<br />That Email is already taken";
    }
    }else{
    echo $valid;
}


    
    function isEmailAvailable($email, $link){
        $query = "Select Email FROM Staff WHERE Email = '$email'";
        $result = mysqli_query($link, $query);
        if(mysqli_num_rows($result) > 0)
        {
            
            $n = false;
            return $n;
        } else{
            $n = true;
            return $n;
        }
        
}

?>
