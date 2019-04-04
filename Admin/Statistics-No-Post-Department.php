<?php include("header.php"); ?>
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          <h1><i class="fas fa-chart-area" style="color:#27aae1;"></i> Number of Post Per Department</h1>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="Statistics-No-Post-Department.php" class="btn btn-primary btn-block">
              <i class="fas fa-edit"></i> Number of Post Per Department
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="Statistics-No-Post-Category.php" class="btn btn-info btn-block">
                <i class="fas fa-edit"></i> Number of Post Per <br>Category
            </a>
          </div>
          <div class="col-lg-3 mb-2 ">
            <a href="/" class="btn btn-warning btn-block">
              <i class="fas fa-user-plus"></i> Number of Contributers Within Each Department
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="Statistics-No-Post-Department-Export.php" class="btn btn-success btn-block">
              <i class="fas fa-file-csv"></i> Download CSV
            </a>
          </div>

        </div>
      </div>
    </header>
    <!-- HEADER END -->

    <!-- Main Area -->
    <section class="container py-2 mb-4">
      <div class="row">
         <!-- Left Side Area Start -->
        <div class="col-lg-2 d-none d-md-block">
          <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
              <h1 class="lead">Posts</h1>
              <h4 class="display-5">
                <i class="fab fa-readme"></i>
                <?php TotalPosts1(); ?>
              </h4>
            </div>
          </div>

          <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
              <h1 class="lead">Categories</h1>
              <h4 class="display-5">
                <i class="fas fa-folder"></i>
                <?php TotalCategories(); ?>
              </h4>
            </div>
          </div>
            
              <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
              <h1 class="lead">Departments</h1>
              <h4 class="display-5">
                <i class="fas fa-folder"></i>
                <?php TotalDepartments(); ?>
              </h4>
            </div>
          </div>
            

          <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
              <h1 class="lead">Admins</h1>
              <h4 class="display-5">
                <i class="fas fa-users"></i>
                <?php TotalAdmins(); ?>
              </h4>
            </div>
          </div>
          <div class="card text-center bg-dark text-white mb-3">
            <div class="card-body">
              <h1 class="lead">Comments</h1>
              <h4 class="display-5">
                <i class="fas fa-comments"></i>
                <?php TotalComments(); ?>
              </h4>
            </div>
          </div>

        </div>
        <!-- Left Side Area End -->
        <!-- Right Side Area Start -->
        <div class="col-lg-10">
          <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
          <h1>Number of Post Per Department</h1>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>No.</th>
                <th>Department Name</th>
                
                <th>Number of Post</th>
              </tr>
            </thead>
            <?php
            $SrNo = 0;
            global $ConnectingDB;
            $sql = "SELECT d.DepartmentID, d.Department, coalesce(oc.Count, 0) as Number_Of_Post from Department d left join ( select DepartmentID, count(*) as Count from Posts group by DepartmentID ) oc on (d.DepartmentID = oc.DepartmentID)";
            $stmt=$ConnectingDB->query($sql);
            while ($DataRows=$stmt->fetch()) {
              $DepID = $DataRows["DepartmentID"];
                $Desc = $DataRows["Department"];
                 $NumPost = $DataRows["Number_Of_Post"];
            
              $SrNo++;
             ?>
            <tbody>
              <tr>
                <td><?php echo $SrNo; ?></td>
                
                   <td><?php echo $Desc; ?></td>
                    <td><?php echo $NumPost; ?></td>
                 
                
                            
         
                 
                </a>
              </td>
              </tr>
            </tbody>
            <?php } ?>

          </table>

        </div>
        <!-- Right Side Area End -->


      </div>
    </section>
    <!-- Main Area End -->

    <!-- FOOTER -->
 <?php include("footer-global.php"); ?>
    <!-- FOOTER END-->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
  $('#year').text(new Date().getFullYear());
</script>
</body>
</html>
