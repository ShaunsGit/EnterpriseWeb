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
                <h3>Admin Panel - Manage Post</h3>
            </div>
            <div class="row">
                <p>
                     <a href="../home.php" class="btn btn-primary">Go Back</a>
                    <a href="create.php" class="btn btn-success">Create</a>
                </p>
                 
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                        
                         <th>Category</th>
                         <th>Department</th>
                        <th>Title</th>
                        <th>Description</th>
                          <th>Date Posted</th>
                          <th>Thumbs Up</th>
                          <th>Thumbs Down</th>
                      
                          <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT PostID,
Title,
Date_Posted,
Up_Vote,
Down_Vote, 
Posts.Description,
Posts.DepartmentID,
Department.Department, 
Posts.CategoryID,
Category.Category, 
Staff.StaffID
FROM Posts 
INNER JOIN Department 
ON Posts.DepartmentID = Department.DepartmentID
INNER JOIN Category 
ON Posts.CategoryID = Category.CategoryID 
INNER JOIN Staff 
ON Posts.StaffID = Staff.StaffID';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['Category'] . '</td>';
                                echo '<td>'. $row['Department'] . '</td>';
                                echo '<td>'. $row['Title'] . '</td>';
                                echo '<td>'. $row['Description'] . '</td>';
                                echo '<td>'. $row['Date_Posted'] . '</td>';
                                echo '<td>'. $row['Up_Vote'] . '</td>';
                                echo '<td>'. $row['Down_Vote'] . '</td>';
                             
                             
                           
                                echo '<td width=250>';
                                echo '<a class="btn btn-primary" href="read.php?id='.$row['StaffID'].'">Read</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="../staff_role/update.php?id='.$row['StaffID'].'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="../staff_role/delete.php?id='.$row['StaffID'].'">Delete</a>';
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