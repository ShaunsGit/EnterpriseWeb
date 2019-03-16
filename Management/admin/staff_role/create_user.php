<?php 
include('../../functions.php');
require ('../../../mysql.php');
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');
if (!isAdmin() and !isManager()) {
	$_SESSION['msg'] = "You must log in first";
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel - Create Staff</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
		.header {
			background: #003366;
		}
		button[name=register_btn] {
			background: #003366;
		}
	</style>
</head>
<body>
	<div class="header">
		<h2>Admin - Create Staff</h2>
	</div>
	
	<form method="post" action="create_user.php">


		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>User type</label>
			<select name="user_type" id="user_type" >
				<option value=""></option>
				<option value="4">Admin</option>
                <option value="3">Manager</option>
                <option value="2">Coordinator</option>
				<option value="1">Staff</option>
			</select>
            
		</div>
        	<div class="input-group">
                	<label>Department</label>
          <select class="" name="department">

                <?php 
                //Calls the function to display departments
                DepartmentDropDown($link);
                ?> 
            </select>
        </div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn"> + Create user</button>
		</div>
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