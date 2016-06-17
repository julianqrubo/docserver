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
    $path = $row["path"];
}

$path_base = '/ftpRepository/';
$path_app = '/docserver';

$files = [];
$files_aux = [];
$uploadId = NULL;
$ruta = getcwd() . $path_base . $path;
//Para abrir archivos necesitaremos poner la codificación
//adecuada con estos valores
$array_codif = Array(
    "UTF-8",
    "ISO-8859-1",
    "ISO-8859-15"
);

//Por defecto usamos esta para htmlentities (ver más abajo)
$codificacion = "ISO-8859-1";

//Vemos si hay algo en el GET
if (isset($_GET)) {
    foreach ($_GET as $campo => $valor) {
        switch ($campo) {
            //Obtenemos una ruta, carpeta o archivo
            case "una-ruta":
                $ruta = htmlspecialchars($valor, ENT_QUOTES);
                if (get_magic_quotes_gpc() == 1)
                    $ruta = stripslashes($ruta);
                break;
            //Vemos la codificación
            case "una-codificacion":
                $codificacion = htmlspecialchars($valor, ENT_QUOTES);
                if (get_magic_quotes_gpc() == 1)
                    $codificacion = stripslashes($codificacion);
                break;
        }
    }
}

//Esta variable contendrá la lista de nodos (carpetas y archivos)
$presenta_nodos = "";

//Esta variable es para el contenido del archivo
$presenta_archivo = "";

//Si la ruta es una carpeta, la exploramos. Si es un archivo
//sacamos también el contenido del archivo.
if (is_dir($ruta)) {//ES UNA CARPETA
    //Con realpath convertimos los /../ y /./ en la ruta real
    $ruta = realpath($ruta) . "/";
    //exploramos los nodos de la carpeta
    $presenta_nodos = explora_ruta($ruta, $path_base, $path, $path_app);
} else {//ES UN ARCHIVO
    $ruta = realpath($ruta);
    //Sacamos también los nodos de la carpeta
    $presenta_nodos = explora_ruta(dirname($ruta) . "/", $path_base, $path, $path_app);
}

//Función para explorar los nodos de una carpeta
//El signo @ hace que no se muestren los errores de restricción cuando
//por ejemplo open_basedir restringue el acceso a algún sitio
function explora_ruta($ruta, $path_base, $path, $path_app) {
    //En esta cadena haremos una lista de nodos
    $cadena = "";
    //Para agregar una barra al final si es una carpeta
    $barra = "";
    //Este es el manejador del explorador
    $manejador = @dir($ruta);
    while ($recurso = $manejador->read()) {
        if ($ruta == getcwd() . $path_base . $path . "/" && !($recurso == ".." || $recurso == ".")) {
            //El recurso sera un archivo o una carpeta
            $nombre = "$ruta$recurso";
            if (@is_dir($nombre)) {//ES UNA CARPETA
                //Agregamos la barra al final
                $barra = "/";
                $cadena .= "<a href=\"" . $_SERVER["PHP_SELF"] . "?una-ruta=$nombre$barra\"><img src='images/folder.png'/>$recurso$barra</a>";
            } else {//ES UN ARCHIVO
                //No agregamos barra
                $barra = "";
                $cadena .= "<a href=download.php?path=" . $ruta . "&filename=" . $recurso . "><img src='images/file.jpg'/>$recurso$barra</a>";
            }
            $cadena .= "<br />";
        }
    }
    $manejador->close();
    return $cadena;
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Repositorio de archivos">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <title>Repositorio de archivos <?php echo $_SERVER["REQUEST_URI"] ?></title>
        <meta name="mobile-web-app-capable" content="yes">
        <link rel="icon" sizes="192x192" href="images/android-desktop.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Software de historias cl&iacute;nicas">
        <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">
        <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
        <meta name="msapplication-TileColor" content="#3372DF">
        <link rel="shortcut icon" href="images/favicon.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.indigo-pink.min.css" />
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <h3 style="text-align: center;">Explorador de archivos</h3>
        <div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%; width: 600px;">
            <span class = "mdl-list__item-primary-content" style="margin-left: 5%; margin-right: 5%; margin-top: 5%; margin-bottom: 5%">
                <?php
                echo "$presenta_nodos";
                //echo "$presenta_archivo";
                ?>
            </span>
        </div>
    </body>
</html>

<?php
include './footer.php';
?>