<!DOCTYPE html>
<?php
session_start();
require 'mysql.php';
$link = mysqli_connect($host, $user, $passwd, $dbName) or 
                die('Failed to connect to MySQL server. ' . mysqli_connect_error() .'<br />');
$error = "";
?>
    <!--- https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/IdeaSubmission.html  -->
    <html lang="en-GB">


    <img class="img1" alt="A screenshot showing CSS Quick Edit" src="mainpic.jpg">



    <head>
        <title>Submit Ideas!</title>
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">


        <link href="main.css" rel="stylesheet" />
    </head>

    <body>
        <ul>
            <li>
                <a href="Home.php">Home</a></li>
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
                <a href="">Edit Ideas</a></li>
            <li>
                <a href="IdeaSubmission.php">Add Ideas</a></li>
            <li>
                <a href="">Search Idea</a></li>
        </ul>
        <h1>Submit Idea</h1>
        <form action="IdeaSubmission.php" method="post" enctype="multipart/form-data">
            <table width="495" height="232" border="0">
                <tr>
                    <td>Title: </td>
                    <td><input size="25" type="text" name="title" required/></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea rows="6" cols="60" type="text" name="description" placeholder="Insert your Idea description here" required></textarea></td>
                </tr>
                <tr>
                    <td>Department: </td>
                    <td><input size="25" type="text" style="background-color: gainsboro;" name="departmentvalue" value="<?php echo $_SESSION['department']; ?>" readonly required/>
                        <input type="hidden" name="department" value="<?php echo $_SESSION['departmentID'] ?>" /></td>
                </tr>

                <tr>
                    <td>Catergory</td>
                    <td>
                        <select name="category">
                        <option value="0" >Other...</option>
                <?php 
                //Calls the function to display departments
                CategoryDropDown($link);
                ?> 
            </select></td>
                </tr>
                <td>File Upload:
                </td>
                <td>File Name:<input type="text" name="altText"> <input type="file" name="file" id="file">
                </td>
                <tr>


                </tr>
            </table>

            <button class="button" type="submit"> Submit Post</button>


            <link href="mainstyle.css" rel="stylesheet" />
        </form>
    </body>

    </html>

    <?php 

       extract($_POST);
if($_POST and $_SESSION['loggedIn'] == true ){
        //prepared statement
        $ps =  $link->prepare("INSERT INTO Posts(StaffID, CategoryID, DepartmentID, UploadID, Title, Description, Date_Posted, Up_Vote, Down_Vote) VALUES(?,?,?,?,?,?,?,?,?)");
        
        $ps->bind_param("iiiisssii", $StaffID, $CategoryID, $DepartmentID, $UploadID, $Title, $Description, $Date_Posted, $Up_Vote, $Down_Vote);
        
        
        $StaffID = $_SESSION['UID'];
        $CategoryID = (int)$category;
        $DepartmentID = $department;
        $UploadID = 0; //temp
        $Title = $title;
        $Description = $description;
        $Date_Posted = date("Y/m/d");
        $Up_Vote = 0;
        $Down_Vote = 0;
        $result = $ps->execute();
        $currPostId = $ps->insert_id; //stores the recent post id in the currPostId variable
 
        //if there is not file
        if ($_FILES["file"]["size"] <= 0) {
            echo "no file set";
        }
    //if there is a file
    else{
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
                echo ' <option  value=' . $row["CategoryID"] . '>' . $row["Category"] .         '</option>';
                        
            }
        } else {
            echo "No results.";
        }
    }
    
    
    


?>
