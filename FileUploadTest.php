<html>
<head>
	<title>Upload & Validate files using PHP - W3Epic.com</title>
</head>
<body>

<?php
$error = "";
if (isset($_FILES["file"])) {
	$allowedExts = array("doc", "docx", "pdf", "odt");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	if ($_FILES["file"]["error"] > 0) {
		$error .= "Error opening the file<br />";
	}
	if ( $_FILES["file"]["type"] != "application/pdf" &&
			$_FILES["file"]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" &&
			$_FILES["file"]["type"] != "application/msword" &&
			$_FILES["file"]["type"] != "application/vnd.oasis.opendocument.text") {	
		$error .= "Mime type not allowed<br />";
	}
	if (!in_array($extension, $allowedExts)) {
		$error .= "Extension not allowed<br />";
	}
	if ($_FILES["file"]["size"] > 102400) {
		$error .= "File size shoud be less than 100 kB<br />";
	}

	if ($error == "") {
		echo "uploaded successfully";
	} else {
		echo $error;
	}
}	
?>

<form action="FileUploadTest.php" method="post" enctype="multipart/form-data">
	<label for="file">Filename:</label>
	<input type="file" name="file" id="file" /><br />
	<input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>