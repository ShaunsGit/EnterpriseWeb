<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Admin Panel - Manage Staff</h3>
            </div>
            <div class="row">
                <p>
                    <a href="../home.php" class="btn btn-primary">Go Back</a>
                    <a href="create_user.php" class="btn btn-success">Create</a>
                </p>
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email Address</th>
                          <th>Post Count</th>
                          <th>Roles</th>
                          <th>Department</th>
                            <th>Number of Comments</th>
                         
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT Staff.StaffID, Name, Email,Post_Count, Comment_Count, Department.DepartmentID, Department,  Roles.RoleID, Roles.Roles 
                       FROM ((Staff 
                        INNER JOIN Department 
                        ON Staff.DepartmentID = Department.DepartmentID) 
                        INNER JOIN Roles 
                        ON Staff.RoleID = Roles.RoleID)';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['Name'] . '</td>';
                                echo '<td>'. $row['Email'] . '</td>';
                                echo '<td>'. $row['Post_Count'] . '</td>';
                                echo '<td>'. $row['Roles'] . '</td>';
                                echo '<td>'. $row['Department'] . '</td>';
                                echo '<td>'. $row['Comment_Count'] . '</td>';
                             
                           
                                echo '<td width=250>';
                                echo '<a class="btn btn-primary" href="read.php?id='.$row['StaffID'].'">Read</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="update.php?id='.$row['StaffID'].'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="delete.php?id='.$row['StaffID'].'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>