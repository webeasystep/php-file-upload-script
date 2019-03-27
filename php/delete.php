<?php
$output_dir = "../uploads/";
if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
{

    $dbLink = new mysqli('localhost', 'root', '', 'demo');
    if(mysqli_connect_errno()) {
        die("MySQL connection failed: ". mysqli_connect_error());
    }
    $fileName =$_POST['name'];
    $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
    $filePath = $output_dir. $fileName;

    // DELETE The File Record from database
    $result = $dbLink->query("DELETE from files WHERE file_path = '$filePath' ");
    if(!$result){
        echo $dbLink->error ;
    }else{

        if (file_exists($filePath))
        {
            unlink($filePath);
        }
        echo "Deleted File ".$fileName."<br>";
    }
}

?>