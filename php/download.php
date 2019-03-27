<?php
if(isset($_GET['filename']))
{
$fileName=$_GET['filename'];


$fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
$file = "../uploads/".$fileName;

if (file_exists($file)) {
	$fileName =str_replace(" ","",$fileName);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    flush(); // Flush system output buffer
    readfile($file);
    exit;

}

}
?>
