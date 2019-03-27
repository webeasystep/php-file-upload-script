<?php

// Connect to the database
$dbLink = new mysqli('localhost', 'root', '', 'demo');
if(mysqli_connect_errno()) {
    die("MySQL connection failed: ". mysqli_connect_error());
}

// Query for a list of all existing files
$result = $dbLink->query('SELECT * from files');
$project = explode('/', $_SERVER['REQUEST_URI'])[1];
$base_url="http://".$_SERVER['SERVER_NAME'].'/'.$project;

// Check if it was successfully
if($result) {
    // Make sure there are some files in there
    if($result->num_rows == 0) {
        echo json_encode("There are no files in the database");
    }
    else {
        $ret= array();
        // Print each file
        while($row = $result->fetch_assoc()) {
                $details = array();
                $details['name']=$row['file_name'];
                $details['path']= $base_url.substr($row['file_path'], 2);
                $details['size']=$row['file_size'];
                $ret[] = $details;

            }
    }

    // Free the result
    $result->free();
    echo json_encode($ret);
}
else
{
    echo json_encode($dbLink->error);
}

// Close the mysql connection
$dbLink->close();



