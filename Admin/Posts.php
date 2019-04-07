<?php include("header.php"); ?>
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          <h1><i class="fas fa-cog" style="color:#27aae1;"></i> Dashboard</h1>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="AddNewPost.php" class="btn btn-primary btn-block">
              <i class="fas fa-edit"></i> Add New Post
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="Categories.php" class="btn btn-info btn-block">
              <i class="fas fa-folder-plus"></i> Add New Category
            </a>
          </div>
          <div class="col-lg-3 mb-2 ">
            <a href="Admins.php" class="btn btn-warning btn-block">
              <i class="fas fa-user-plus"></i> Add New Admin
            </a>
          </div>
          <div class="col-lg-3 mb-2">
            <a href="Comments.php" class="btn btn-success btn-block">
              <i class="fas fa-check"></i> Approve Comments
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
              <h1 class="lead">Members</h1>
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
          <h1>Manage Post</h1>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                <th>Name</th>
                <th>Title</th>
                  <th>Description</th>
                  <th>Thumbs Up</th>
                      <th>Thumbs Down</th>
                   <th>Anonymous</th>
                  <th>Action</th>
                  <th>Preview</th>
              
            
             
              </tr>
            </thead>
                <?php
      global $ConnectingDB;
      $sql = "SELECT * FROM Posts";
      $Execute =$ConnectingDB->query($sql);
   
      while ($DataRows=$Execute->fetch()) {
           $Id = $DataRows["PostID"]; 
          $Name = $DataRows["Name"];
        $Title = $DataRows["Title"];
          $Desc = $DataRows["Description"];
     $Thumbs_up = $DataRows["Up_Vote"];
           $Thumbs_down = $DataRows["Down_Vote"];
       $Anon = $DataRows["Anonymous"];
            
      ;
        
        
      ?>
      <tbody>
        <tr>
          
          <td><?php echo htmlentities($Name); ?></td>
          <td><?php echo htmlentities($Title); ?></td>
             <td><?php echo htmlentities($Desc); ?></td>
              <td><span class="badge badge-success"><?php echo htmlentities($Thumbs_up); ?></td>
         <td><span class="badge badge-danger"><?php echo htmlentities($Thumbs_down); ?></td>
           <td><?php echo htmlentities($Anon); ?></td>
         
        
    <td>
                <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
              </td>
              <td>
                <a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Preview</span></a>
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
