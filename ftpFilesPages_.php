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
//Cantidad de resultados por página (debe ser INT, no string/varchar)
$cantidad_resultados_por_pagina = 100;
@$pagina = $_GET ['pagina'];
//echo "la pag es::::::: " . $pagina . "<br>";

if (isset($pagina)) {
    if (is_string($pagina)) {
        if (is_numeric($pagina)) {
            if ($pagina == 1) {
                header('Location: ftpFilesPages.php');
            } else {
                $pagina = $pagina;
            }
        } else {
            $pagina = 1;
        }
    }
} else {
    $pagina = 1;
}
$empezar_desde = ($pagina - 1) * $cantidad_resultados_por_pagina;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Explorador de archivos</title>

        <style>
            section>div	{clear:both;}
            .group		{overflow:hidden;padding:2px;}
            section .group:nth-child(odd) {background:#e5e5e5;}
            .directory	{font-weight:bold;}
            .name		{float:left;width:700px;overflow:hidden;}
            .mime		{float:left;margin-left:10px;}
            .size		{float:right;}
            .bold		{font-weight:bold;}
            footer		{text-align:center;margin-top:20px;color:#808080;}
        </style>
    </head>

    <body>
        <h3 style="text-align: center;">Explorador de archivos</h3>
        <div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%; width: 700px;">
            <?php
            $total_registros = sizeof($files_array);
            $total_paginas = ceil($total_registros / $cantidad_resultados_por_pagina);
            $num_row = $cantidad_resultados_por_pagina + $empezar_desde;
            if ($num_row > $total_registros) {
                $num_row = $total_registros;
            }
            for ($i = $empezar_desde; $i < $num_row; $i++) {
                ?>
                <span class = "mdl-list__item-primary-content" style="margin-left: 2%; margin-right: 1%; margin-top: 2%; margin-bottom: 2%">
                    <?php
                    if ($files_array[$i]) {
                        echo json_encode($files_array[$i]) . "<br>";
                    }
                    ?>
                </span>
            <?php } ?>
        </div>
        <hr>
        <?php
        echo "<center><p>";
        if ($total_registros > $cantidad_resultados_por_pagina) {
            if (($pagina - 1) > 0) {
                echo "<span><a href='ftpFilesPages.php?pagina=" . ($pagina - 1) . "'>&laquo; Anterior</a></span> ";
            }
            // Numero de paginas a mostrar
            $num_paginas = 10;
            $pagina_hasta = $pagina + $num_paginas;
            if ($pagina_hasta > $total_paginas) {
                $pagina_hasta = $total_paginas;
            }
            for ($k = $pagina; $k < $pagina_hasta; $k++) {
                if ($pagina == $k) {
                    echo "<span>" . $pagina . "</span> ";
                } else {
                    echo "<span><a href='ftpFilesPages.php?pagina=$k'>$k</a></span> ";
                }
            }
            if (($pagina + 1) <= $total_paginas) {
                echo " <span><a href='ftpFilesPages.php?pagina=" . ($pagina + 1) . "'>Siguiente &raquo;</a></span>";
            }
        }
        echo "</p></center>";
        ?>
    </body>
</html>
<?php
//finfo_close($finfo1);
//finfo_close($finfo2);
include './footer.php';
?>