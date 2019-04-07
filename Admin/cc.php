<?php require_once("Includes/DB.php"); ?>


<?php

$stmt = $ConnectingDB->query("SELECT * FROM Posts");
$TotalPost = $stmt->rowCount();
echo $TotalPost ;


?>