<?php
 
//Connect to our MySQL database using the PDO extension.
$pdo = new PDO('mysql:host=mysql.cms.gre.ac.uk;dbname=mdb_sm2418r', 'sm2418r', 'sm2418r');

//Our select statement. This will retrieve the data that we want.
$sql = "SELECT RoleID, Roles FROM Roles";
 
//Prepare the select statement.
$stmt = $pdo->prepare($sql);
 
//Execute the statement.
$stmt->execute();
 
//Retrieve the rows using fetchAll.
$roles = $stmt->fetchAll();
 
?>
 ROLE MANAGEMENT SYSTEM
 <br>
<select>
    <?php foreach($roles as $role): ?>
        <option value="<?= $role['RoleID']; ?>"><?= $role['Roles']; ?></option>
    <?php endforeach; ?>
</select>