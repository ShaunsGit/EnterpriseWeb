<!DOCTYPE html>
<!--- https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/IdeaSubmission.html  -->
<?php
session_start();
//ini_set('display_errors',1);
//    error_reporting(E_ALL);
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br/>');
$error = "";
?>
    <!--- https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/IdeaSubmission.html  -->
    <html lang="en-GB">

    <head>
        <title>Submit Ideas!</title>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

        <link href="main.css" rel="stylesheet"/>

    </head>

    <body>
        <img class="img1" alt="A screenshot showing CSS Quick Edit" src="mainpic1.jpg">
        <ul>
            <li>
                <a href="Home.php">Home</a></li>
            <li>
                <a href="">Search Idea</a></li>
            <?php if($_SESSION['loggedIn'] == true){
    echo '<li style="float:right">
    <a href="Logout.php">Logout</a></li>';
}else {
    echo '
    <li style="float:right">
    <a href="Register.php">Register</a></li>
    <li style="float:right">
    <a href="Login.html">Sign In</a></li>
    <li>';
}
                ?>
            <li>
                <a href="">My Ideas</a></li>
          
            <li>
                <a href="IdeaSubmission.php">Add Ideas</a></li>
            
        </ul>
        <h1 style="background-color:rgba(9,49,69, 0.95); margin-bottom:0px;color:#EFD469">Submit Idea</h1>
        <form action="IdeaSubmission.php" method="post" enctype="multipart/form-data">
            <table width="495" height="232" border="0"><tr><td> <label for="title">Title:</label></td>
                    <td>
                        <div class="form-group">
                            <input id="title" size="25" name="title" type="text" placeholder="Enter title (Case Sensitive.)" class="form-control textField form-control-sm shadow">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <div class="form-group">
                            <textarea rows="6" cols="60" type="text" name="description" placeholder="Insert your Idea description here" class="form-control textField form-control-sm shadow" required></textarea>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Department: </td>
                    <td>
                        <div class="form-group">
                            <input size="25" type="text" style="background-color: gainsboro;"   name="departmentvalue" id="readOnly" class="form-control textField form-control-sm shadow" value="<?php echo $_SESSION['department']; ?>" readonly/>
                            <input type="hidden" name="department" value="<?php echo $_SESSION['departmentID']; ?>" />
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Catergory</td>
                    <td>
                        <select class="form-control form-control-sm textField shadow" name="category">
                       
                <?php 
                //Calls the function to display departments
                CategoryDropDown($link);
                ?> 
            </select></td>
                </tr>

                <td>File Upload:
                </td>
                <td>
                    <div class="custom-file textField shadow">
                        <input type="file" class="custom-file-input shadow" name="file" id="file">
                        <label class="custom-file-label" id="fileHelp" for="inputGroupFile02">Choose file</label>
                        <small id="emailHelp" class="form-text ">You can upload a file to help support your idea!.(JPEG, GI PDF ...)</small>
                    </div>

                </td>
                <tr>
                    <td></td>
                    <td><input type="checkbox" name="anon" value="1"> Check This box to post anonymously.<br>
                    <p></p>
<!--                        <input type="checkbox" name="terms" value="1"> Check this box to agree to the <b><u>Terms and Conditions</u></b><br>-->
                    </td>

                </tr>
                <tr>
                    <td>
                        <div class="input-group mb-3">

                        </div>
                    </td><td></td>
                </tr>
            </table>
            <button class="button" type="submit"> Submit Post</button>
        </form>
    </body>
    </html>

    <?php 
       extract($_POST); // Extracts all post data into variables.
//if ($_POST && !isset($_POST['terms'])){
//    echo "please agree with the terms";
//}else{
if($_POST and $_SESSION['loggedIn'] == true ){
        // Prepared statement to upload the post to the Post table
        $ps =  $link->prepare("INSERT INTO Posts(StaffID, CategoryID, DepartmentID, UploadID, Title, Description, Date_Posted, Up_Vote, Down_Vote, Anonymous) VALUES(?,?,?,?,?,?,?,?,?,?)");
        //setting the the query
        $ps->bind_param("iiiisssiii", $StaffID, $CategoryID, $DepartmentID, $UploadID, $Title, $Description, $Date_Posted, $Up_Vote, $Down_Vote, $Anonymous);
        
        //assigning the data to the values.
        //assigning the data to the values.
        $StaffID = $_SESSION['UID'];
        $CategoryID = (int)$category;
        $DepartmentID = $department;
        $UploadID = 0; //temp
        $Title = $title;
        $Description = $description;
        $Date_Posted = date("Y/m/d");
        $Up_Vote = 0;
        $Down_Vote = 0;
        $Anonymous = (int)$anon;
        $result = $ps->execute();
        $currPostId = $ps->insert_id; //stores the recent post id in the currPostId variable
    
        if($result){
            //1. get the current post count
            //2. +1 to the current post count
            //3. update the user table with new post count
            
            
            $query = "SELECT Post_Count FROM Staff WHERE StaffID = " . $StaffID;
            $result = mysqli_query($link,$query);
            if(mysqli_num_rows($result) > 0){
                
                while($row = mysqli_fetch_assoc($result)) {
                    $newPostCount = $row['Post_Count'];
                }
                
                $newPostCount += 1; 
                $query = "UPDATE Staff SET Post_Count = " . $newPostCount . " Where StaffID = " . $StaffID;
                $_SESSION['postCount'] = $newPostCount;
                mysqli_query($link,$query);
                
                EmailCoord($DepartmentID, $currPostId, $link);
                header("Location: Home.php");
                exit;
                
         
            }
            
        }
       //if the user uploads a file, it gets validated and uploaded to the Upload table.
        if ($_FILES["file"]["size"] > 0) {
            $isFileValid = ValidateFileUpload();         
            if($isFileValid){
                $fileName = $_FILES["file"]["name"];
                $fileSize = $_FILES["file"]["size"];
                $fileType = $_FILES["file"]["type"];
                $fileTmpName = $_FILES["file"]["tmp_name"];
                
                if($fileName && !empty($fileName)){
                    if($_FILES['file']['type']){
                        if ( !preg_match( '/gif|png|x-  png|jpeg|jpg|DOC|DOCX|PDF|doc|docx|pdf|/',   $_FILES['file']['type']) ) {
                            die('<p>Only browser compatible images allowed</p></body>   </html>');
                        } else if ( strlen($_POST['altText']) < 5 ) {
                            die('<p>Please provide meaningful alternate text</p></body> </html>');
                        } else if ( $_FILES['file']['size'] > 3200000 ) {
                            die('<p>Sorry file too large</p></body></html>');
                            // Connect to database
                        } else if ( !($link = mysqli_connect($host, $user, $passwd,     $dbName)) ) {
                            die('<p>Error connecting to database</p></body></html>');
                            // Copy image file into a variable
                        } else if ( !($handle = fopen ($_FILES['file']['tmp_name'], "r")) ) {
                            die('<p>Error opening temp file</p></body></html>');
                        } else if ( !($image = fread ($handle, filesize($_FILES['file']         ['tmp_name']))) ) {
                            die('<p>Error reading temp file</p></body></html>');
                        } else {
                            fclose ($handle);
                            // Commit image to the database
                            $image = mysqli_real_escape_string($link, $image);
                            $alt = htmlentities($_POST['altText']);
                            $query = "INSERT INTO Upload(PostID, StaffID, Type, Name, Alt, Data)    VALUES(".(int)$currPostId.",".(int)$StaffID.",'".$_FILES['file']['type']."','".$_FILES['file']['name']."','".$alt."','".$image."')";
                            
                            if(mysqli_query($link, $query)){
                                $uploadTableLastId = $link->insert_id;
                                echo "<br /> File has been uploaded. <br/> the last insert ID was: " . $uploadTableLastId;
                                $query = "UPDATE Posts
                                set UploadID = ".$uploadTableLastId."
                                where PostID = ".$currPostId.";";
                                if(mysqli_query($link, $query)){
                                    echo "<br/> Update Query Successful.";
                                }
                                
                            }
                            
                        } 
                    }
                    
                }
            }
        }

    }
//} 

    
    function ValidateFileUpload(){
      
        //NEED TO CHANGE IT SO THAT THE WEBSITE ONLY ACCEPTS PDF, DOC and IMG FILES.
        $allowedExts = array("doc", "docx", "pdf", "odt", "jpg", "jpeg", "gif", "img");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        
        if ($_FILES["file"]["error"] > 0) {
            $error .= "Error opening the file<br />";
        }
        
        if (!in_array($extension, $allowedExts)) {
            $error .= "Extension not allowed<br />";
        }
        if ($_FILES["file"]["size"] > 102400) {
            $error .= "File size shoud be less than 100 kB<br />";
        }
        
        if ($error == "") {
            return true;
        } else {
            return $error;
        }
        
    }
    
    function CategoryDropDown($link){
        /*Pulls the departments from the department table and displays it as a
        drop down list */
        
        $query = "SELECT * FROM Category";
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)) {
                echo ' <option  value=' . (int)$row["CategoryID"]  . '>' . $row["Category"] .         '</option>';
                        
            }
        } else {
            echo "No results.";
        }
    }


    function EmailCoord($department, $postId, $link){
      
        // 1. Get the departmentid of the post and the name from the department db
        // 2. Get all QAcoords within that depart
        // 3. Send Notification Email to every Coord
    
        $query = "SELECT * FROM Department Where DepartmentID=$department";
        $result = mysqli_query($link, $query);
         if (mysqli_num_rows($result) >= 1){
            while($row = mysqli_fetch_assoc($result)) {
                $departmentName = $row['Department'];       
            }
         }
        
        //emails the all coords within the department when a post is made
        $query = "SELECT * FROM Staff WHERE RoleID = 2 AND DepartmentID=". $department;
        $result = mysqli_query($link, $query);
         if (mysqli_num_rows($result) >= 1){
            while($row = mysqli_fetch_assoc($result)) {
                $email = $row['Email'];
                $subject = "New Post! ($departmentName)";
                mail($email, $subject , "Dear Quality Assurance Coordinator,\nA new post has been made within your department ($departmentName). Please find the new post by following the link below! You will have to log in if you have not already.\nhttps://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/Post.php?PostID=$postId \n\nThis is just a notification.Please do not reply to this email.", "From: sm2418r@gre.ac.uk");
            }
         }
   
     
    }
    
    
    


?>
