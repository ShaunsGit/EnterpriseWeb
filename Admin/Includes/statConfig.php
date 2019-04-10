<?php
//DB details
$dbHost     = 'mysql.cms.gre.ac.uk';
$dbUsername = 'sm5896j';
$dbPassword = 'sm5896j';
$dbName     = 'mdb_sm5896j';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if($db->connect_error){
    die("Unable to connect database: " . $db->connect_error);
}