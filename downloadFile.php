<?php

session_start();
$path_file_srv = $_GET['path'];
$filename = $_GET['filename'];
$fileid = $_GET['fileid'];
$ext = end(explode('.', $filename));

//echo $path_file_srv."<br />";
//echo $fileid."<br />";
//echo $filename."<br />";
//echo $ext."<br />";
//echo $path_file_srv.$fileid.".".$ext;

header("Content-type: application/octet-stream"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"$filename\"\n"); readfile($path_file_srv.$fileid.".".$ext);
?>