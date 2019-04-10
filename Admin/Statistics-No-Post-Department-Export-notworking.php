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

//get records from database
$query = $db->query("SELECT d.DepartmentID, d.Department, coalesce(oc.Count, 0) as Number_Of_Post from Department d left join ( select DepartmentID, count(*) as Count from Posts group by DepartmentID ) oc on (d.DepartmentID = oc.DepartmentID");



if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "number_of_post_per_department" . date('Y-m-d') . ".csv";
    
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('DepartmentID', 'Department', 'Number_Of_Post');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
       
        $lineData = array($row['DepartmentID'], $row['Department'], $row['Number_Of_Post'] );
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>