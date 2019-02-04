<!DOCTYPE html>
<!--- https://stuweb.cms.gre.ac.uk/~sm2418r/Enterprise/IdeaSubmission.html  -->
<html lang="en-GB">
<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
	
	<link href="mainstyle.css" rel="stylesheet" />
</head>
<body>
 <ul>Create a Post</ul>
    <form action="Home.php" method="post">
    <label>Title</label><input type="text" name="title" /><br /><br />
    <label>description</label><input type="text" name="description" /><br /><br />
    <label>department</label><input type="text" name="department" value="<?php echo $_SESSION['department'] ?>" readonly/><br /><br />
        
        <button type="submit"> Submit Post</button>
    </form>
</body>
</html>
