<?php
$output_dir = "../uploads/";
$dbLink = new mysqli('localhost', 'root', '', 'demo');
if(mysqli_connect_errno()) {
    die("MySQL connection failed: ". mysqli_connect_error());
}


if(isset($_FILES["myfile"]))
{
	$ret = array();
	
//	This is for custom errors;	
/*	$custom_error= array();
	$custom_error['jquery-upload-file-error']="File already exists";
	echo json_encode($custom_error);
	die();
*/

	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
        $fileName = $_FILES["myfile"]["name"];
        $filePath = $output_dir.$fileName ;
        $file_size = intval($_FILES['myfile']['size']);
        // upload file
       $uploaded = move_uploaded_file($_FILES["myfile"]["tmp_name"],$filePath);
       if(!$uploaded){
           echo 'Error! Failed to Upload the file ';exit;
       }
        // Create the SQL query
        $query = " INSERT INTO files (file_name,file_path,file_size,created_at)
                   VALUES ( '{$fileName}','{$filePath}', {$file_size}, NOW() )";
        // Execute the query
        $result = $dbLink->query($query);
        // Check if it was successfull
        if(!$result) {
            echo 'Error! Failed to insert the file'. "<pre>{$dbLink->error}</pre>";exit;
        }
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["myfile"]["name"][$i];
        $filePath = $output_dir.$fileName ;
        $file_size = intval($_FILES['myfile']['size'][$i]);
          // upload file
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  	$ret[]= $fileName;
          // Create the SQL query
          $query = " INSERT INTO files (file_name,file_path,file_size,created_at)
                   VALUES ( '{$name}', '{$filePath}', {$file_size}, NOW() )";
          // Execute the query
          $result = $dbLink->query($query);
          if(!$result) {
              echo 'Error! Failed to insert the file'. "<pre>{$dbLink->error}</pre>";exit;
          }
	  }
	
	}
    echo json_encode($ret);
 }
 ?>