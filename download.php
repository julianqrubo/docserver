<?php

session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
$path_file_srv = $_GET['path'];
$filename = $_GET['filename'];

$file = $path_file_srv;
$filename = $filename;
header("Content-type: application/octet-stream");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=\"$filename\"\n");
readfile($file."/".$filename);
?>