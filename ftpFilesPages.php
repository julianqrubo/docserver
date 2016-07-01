<?php

session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
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

$finfo1 = finfo_open(FILEINFO_MIME_TYPE);
$finfo2 = finfo_open(FILEINFO_MIME_ENCODING);
$folder = 0;
$file = 0;
# recorremos todos los archivos de la carpeta

$files_array = array();

// obtenemos la ruta a revisar, y la ruta anterior para volver...
if ($_GET["path"]) {
    $path = $_GET["path"];
    $back = implode("/", explode("/", $_GET["path"], -2));
    if ($back)
        $back.="/*";
    else
        $back = "*";
}else {
    $path = $path_base . $path_company . "/*";
}

foreach (glob($path) as $filename) {
    $recurso = end(explode("/", $filename));
    $fileMime = finfo_file($finfo1, $filename);
    $fileEncoding = finfo_file($finfo2, $filename);
    if ($fileMime == "directory") {
        $folder+=1;
        // mostramos la carpeta y permitimos pulsar sobre la misma
        $files_array[] = array("name" => end(explode("/", $filename)), "type" => "folder");
    } else {
        $file+=1;
        // mostramos la información del archivo
        $files_array[] = array("name" => $recurso, 'type' => "file", 'size' => number_format(filesize($filename) / 1024, 2, ",", ".") . " Kb");
    }
}

//echo json_encode($files_array);

$conta_rows = sizeof($files_array);

//Limito la busqueda
$TAMANO_PAGINA = 30;

$pagina = $_GET["offset"];

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $TAMANO_PAGINA;
}

//calculo el total de páginas
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

if ($total_paginas > 1) {
    if ($pagina != 1){
        
    }
    for ($j = 0; $j < $total_paginas; $i++) {
        if ($pagina == $j){
            echo $pagina;
        }else{
            echo '<a href="downloadFile.php?offset=" . $j . ">' . $j . '</a>  ';
        }
    }
    if ($pagina != $total_paginas){
        
    }
}

finfo_close($finfo1);
finfo_close($finfo2);
?>