<?php include("header.php"); ?>
   
    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          <h1><i class="fas fa-comments" style="color:#27aae1;"></i> Manage Comments</h1>
          </div>
        </div>
      </div>
    </header>
    <!-- HEADER END -->
    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
      <div class="row" style="min-height:30px;">
        <div class="col-lg-12" style="min-height:400px;">
          <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
          <h2>View All Comments</h2>
          <table class="table table-striped table-hover">
            <thead class="thead-dark">
              <tr>
                
                 <th>Name </th>
                  <th>Post Title </th>
                <th>Comment</th>
              
                <th>Action</th>
                <th>Details</th>
              </tr>
            </thead>
          <?php
          global $ConnectingDB;
          $sql = "SELECT Comments.CommentID, Comments.Text, Comments.PostID, Staff.Name, Posts.Title
FROM Comments 
left JOIN Staff
ON Comments.StaffID =Staff.StaffID
left Join Posts
ON Comments.PostID =Posts.PostID
";
          $Execute =$ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows=$Execute->fetch()) {
            $CommentId = $DataRows["CommentID"];
               $Name = $DataRows["Name"];
              $Title = $DataRows["Title"];
       
            $CommentContent= $DataRows["Text"];
            $CommentPostId = $DataRows["PostID"];
            $SrNo++;
          ?>
          <tbody>
            <tr>
             
             <td><?php echo htmlentities($Name); ?></td>
                <td><?php echo htmlentities($Title); ?></td>
              
           
              <td><?php echo htmlentities($CommentContent); ?></td>
        
              <td> <a href="DeleteComments.php?id=<?php echo $CommentId;?>" class="btn btn-danger">Delete</a>  </td>
              <td style="min-width:140px;"> <a class="btn btn-primary"href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a> </td>
            </tr>
          </tbody>
          <?php } ?>
          </table>
          
   <!--  Main Area End -->
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
