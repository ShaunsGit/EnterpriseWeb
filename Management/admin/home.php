<?php 
include('../functions.php');

if (!isAdmin() and !isManager()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	 session_unset();
	header("location: https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/Home.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
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
        <h2>Admin - Home Page</h2>
    </div>
    <div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success">
            <h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
        </div>
        <?php endif ?>

        <!-- logged in user information -->
        <div class="profile_info">
            <img src="../images/admin_profile.png">

            <div>
                <?php  if (isset($_SESSION['user'])) : ?>
                <strong><?php echo $_SESSION['user']['Name']; ?></strong>

                <small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['usertype']); ?>)</i> 
						<br>
						<a href="home.php?logout='1'" style="color: red;">logout</a>
                       &nbsp; <a href="create_user.php"> + add user</a>
					</small>
                <br>
                <a href="staff_role/index.php">Manage Staff</a>
                <br>

                <a href="manage_post/index.php">Manage Post</a>
                <br>
                <a href="departments.php">Manage Departments</a>
                <br>
                <a href="roles.php">Roles</a>
                <br>
                <a href="statistics.php">Statistics</a>
                <br><br>
                <a href="../../Home.php">Back to the main website.</a>

                <?php endif ?>
            </div>
        </div>
    </div>
</body>

</html>
