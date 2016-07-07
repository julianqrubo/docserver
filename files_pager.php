<?php

session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}

include './db.php';

$path = "";
$company = $_SESSION['__company__'];
$stmt = $db->prepare("SELECT path FROM company WHERE id = ?");
$stmt->execute(array($company));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    $path_company = $row["path"];
}
$path_base = 'ftpRepository/';
$path_app = '/docserver';

$path = $path_base . $path_company . "/*";

$files_page = array();


$dirFiles = glob(getcwd() ."/".$path);

$offset = filter_input(INPUT_GET, "page");
$limit = 5;

$start = $offset * $limit;
$end = $start + $limit;
if( $end > count($dirFiles) ){
    $end = count($dirFiles);
}

$files_page[] = array("start" => $start, "end" => $end, $total => count($dirFiles));

for ($i=$start; $i<$end; ++$i){
    $filename = $dirFiles[$i];
    $recurso = end(explode("/", $filename));
    $files_page[] = array( "name" => $recurso, "folder" => is_dir($filename));
    
}

echo json_encode($files_page);