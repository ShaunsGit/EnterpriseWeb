<?php
/* vars for export */
// database record to be exported

// optional where query
$where = '';
// filename for export
$csv_filename = 'Number_of_post_per_category'.$db_record.'_'.date('Y-m-d').'.csv';
// database variables
$hostname = "mysql.cms.gre.ac.uk";
$user = "sm5896j";
$password = "sm5896j";
$database = "mdb_sm5896j";

$conn = mysqli_connect($hostname, $user, $password, $database, $port);
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
// create empty variable to be filled with export data
$csv_export = '';
// query to get data from database
$query = mysqli_query($conn, "SELECT c.CategoryID, c.Category, coalesce(oc.Count, 0) as Number_Of_Post from Category c left join ( select CategoryID, count(*) as Count from Posts group by CategoryID ) oc on (c.CategoryID = oc.CategoryID)".$db_record." ".$where);
$field = mysqli_field_count($conn);
// create line with field names
for($i = 0; $i < $field; $i++) {
    $csv_export.= mysqli_fetch_field_direct($query, $i)->name.';';
}
// newline (seems to work both on Linux & Windows servers)
$csv_export.= '
';
// loop through database query and fill export variable
while($row = mysqli_fetch_array($query)) {
    // create line with field values
    for($i = 0; $i < $field; $i++) {
        $csv_export.= '"'.$row[mysqli_fetch_field_direct($query, $i)->name].'";';
    }
    $csv_export.= '
';
}
// Export the data and prompt a csv file for download
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);



















