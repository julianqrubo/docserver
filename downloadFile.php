<?php

session_start();
echo "Descargando archivo____";
$path_file_srv = $_GET['path'];
echo $path_file_srv."_____";
$filename = $_GET['filename'];
echo $filename."_____";
header("Content-type: application/octet-stream"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"$filename\"\n"); readfile($path_file_srv);
?>