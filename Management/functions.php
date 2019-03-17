<?php 
session_start();

// connect to database
$db = mysqli_connect('mysql.cms.gre.ac.uk', 'sm2418r', 'sm2418r', 'mdb_sm2418r');

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO Staff (Name, Email, usertype, RoleID, Password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}else{
			$query = "INSERT INTO staff (Name, Email, usertype, Password) 
					  VALUES('$username', '$email', 'user', '$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');				
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM Staff WHERE StaffID=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}	

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
    session_unset();
	header("location: https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/Home.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
	

		$query = "SELECT * FROM Staff WHERE Email='$username'";
		$results = mysqli_query($db, $query);
       
		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
            
			$logged_in_user = mysqli_fetch_assoc($results);
            $hash = $logged_in_user['Password'];
            
            if(password_verify($password, $hash)){
			if ($logged_in_user['RoleID'] == '4' || $logged_in_user['RoleID'] == '3') {

				$_SESSION['user'] = $logged_in_user;
                $_SESSION["role"] = getRole($logged_in_user['RoleID']);
                $_SESSION["Name"] = $logged_in_user['Name'];
                $_SESSION['UID'] = $logged_in_user['StaffID'];
                $_SESSION['loggedIn'] = true;
                $_SESSION['departmentID'] = $logged_in_user['DepartmentID'];
                $_SESSION['lastLogged'] = $logged_in_user['Last_Logged'];
                $_SESSION['postCount'] = $logged_in_user['Post_Count'];
                $_SESSION['success']  = "You are now logged in as ". $_SESSION["role"];
                
                header('location: admin/home.php');		 
                print_r($_SESSION['user']);
                
            }else{
                array_push($errors, "Wrong username/password combination");
            }
             }
            else {
                array_push($errors, "Wrong username/password combination");
            }
        }
    }
    }


function getRole($id){
    
    if($id == "4"){
        return "Admin";
    } 
    if($id == "3"){
        return "QAmanager";
    } 
    
    
}
    
function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['RoleID'] == '4' ) {
		return true;
	}else{
		return false;
	}
}
    
    function isManager()
{
	if (isset($_SESSION['role']) && $_SESSION['user']['RoleID'] == '3' ) {
		return true;
	}else{
		return false;
	}
    }
        function isCoordinator()
{
	if (isset($_SESSION['role']) && $_SESSION['role'] == 'QAcoord' ) {
		return true;
	}else{
		return false;
	}
}
