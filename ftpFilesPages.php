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

// Variable para guardar la información para mostrar de cada archivo
$files_array = array();

// obtenemos la ruta a revisar, y la ruta anterior para volver...
@$get_path = $_GET["path"];
if ($get_path) {
    $path = $get_path;
    $back = implode("/", explode("/", $get_path, -2));
    if ($back)
        $back.="/*";
    else
        $back = "*";
}else {
    $path = $path_base . $path_company . "/*";
}

// si no estamos en la raiz, permitimos volver hacia atras
if ($path != $path_base . $path_company . "/*") {
    echo "<div class='bold group'><a href='?path=" . $back . "'><img src='images/back.png'/></a></div>";
}
$finfo1 = finfo_open(FILEINFO_MIME_TYPE);
$finfo2 = finfo_open(FILEINFO_MIME_ENCODING);
$folder = 0;
$file = 0;

//Cantidad de resultados por página
$cantidad_resultados_por_pagina = 20;
@$pagina = $_GET ["pagina"];
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
echo "la pag es::::::: " . $pagina . "<br>";
$conta_archivo = ($pagina - 1) * $cantidad_resultados_por_pagina;
echo "conta_archivo:::::: " . $conta_archivo . "<br>";
echo "el path es:::::::: " . $path . "<br>";
echo getcwd() . "<br>";

//var/www/html/docserver/ftpRepository/jmsaludocupacional/*
foreach (glob(getcwd() ."/".$path) as $filename) {
    $recurso = end(explode("/", $filename));
    echo $recurso . "<br>";
}


/* while ($conta_archivo < ($conta_archivo + $cantidad_resultados_por_pagina)) {
  // Recorro los archivos del directorio
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
  $conta_archivo+=1;
  }

  echo json_encode($files_array);

  $empezar_desde = ($pagina - 1) * $cantidad_resultados_por_pagina;
  ?>
  <body>
  <?php
  $total_registros = sizeof($files_array);
  $total_paginas = ceil($total_registros / $cantidad_resultados_por_pagina);
  $num_row = $cantidad_resultados_por_pagina + $empezar_desde;
  if ($num_row > $total_registros) {
  $num_row = $total_registros;
  }
  for ($i = $empezar_desde; $i < $num_row; $i++) {
  ?>
  <span>
  <?php
  if ($files_array[$i]) {
  echo json_encode($files_array[$i]) . "<br>";
  }
  ?>
  </span>
  <?php } ?>
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
  echo "<span><a href='ftpFilesPages.php?pagina=" . $k . "'>" . $k . "</a></span> ";
  }
  }
  if (($pagina + 1) <= $total_paginas) {
  echo "<span><a href='ftpFilesPages.php?pagina=" . ($pagina + 1) . "'>Siguiente &raquo;</a></span>";
  }
  }
  echo "</p></center>";
  ?>
  </body>
  <?php
  //finfo_close($finfo1);
  //finfo_close($finfo2); */





include './footer.php';
?>