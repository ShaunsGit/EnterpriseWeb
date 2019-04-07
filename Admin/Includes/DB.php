<?php
$DSN='mysql:host=mysql.cms.gre.ac.uk;dbname=mdb_sm5896j';
$username = 'sm5896j';
$password = 'sm5896j';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 

$ConnectingDB = new PDO($DSN, $username, $password, $options);
?>


