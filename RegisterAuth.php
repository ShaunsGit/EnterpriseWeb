<?php
//Uploads the data sent from Reister.html to the Staff table in the database.
session_start();
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');






extract($_POST);

    $valid;
    if( !preg_match('/^([\w\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/',         $email))
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

                $hash = password_hash($pass, PASSWORD_DEFAULT); //hashes the password
                
                $ps =$link->prepare("INSERT INTO Staff (DepartmentID, RoleID, Email, Name, Password, Date_Joined, Last_Logged, Post_Count, Comment_Count, Active) Values(?,?,?,?,?,?,?,?,?,?)");
                
                // Binding/ setting the parameters for the query
                $ps-> bind_param("iisssssiii", $DepartmentID, $RoleID, $Email, $Name, $Password, $Date_Joined, $Last_Logged, $Post_Count, $Comment_Count, $Active);
            
                //assiging the variables with the users inputs.
                $DepartmentID = $department;
                $RoleID = 1;
                $Email = $email;
                $Name = $name;
                $Password = $hash;
                $Date_Joined = date("Y/m/d");
                $Last_Logged = date("Y/m/d");
                $Post_Count = 0;
                $Comment_Count = 0;
                $Active = true;
                $result = $ps->execute();
                
             if($result){
                  setcookie("email", urldecode($Email), time() + (86400 * 30), "/"); // 86400 = 1 day
                 header("location: Login.html");
             }

           
        } else {
            echo "<br />Password was not the same";
        }
    } else{
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
                