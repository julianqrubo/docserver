<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
$files = [];
$files_aux = [];
$uploadId = NULL;
$ruta = getcwd() . '/fileRepository/';

$array_codif = Array(
    "UTF-8",
    "ISO-8859-1",
    "ISO-8859-15"
);

$codificacion = "ISO-8859-1";

if (isset($_GET)) {
    foreach ($_GET as $campo => $valor) {
        switch ($campo) {
            case "una-ruta":
                $ruta = htmlspecialchars($valor, ENT_QUOTES);
                if (get_magic_quotes_gpc() == 1)
                    $ruta = stripslashes($ruta);
                break;
            case "una-codificacion":
                $codificacion = htmlspecialchars($valor, ENT_QUOTES);
                if (get_magic_quotes_gpc() == 1)
                    $codificacion = stripslashes($codificacion);
                break;
        }
    }
}
$presenta_nodos = "";

if (is_dir($ruta)) {
    $ruta = realpath($ruta) . "/";
    $presenta_nodos = explora_ruta($ruta);
} else {
    $ruta = realpath($ruta);
    $presenta_nodos = explora_ruta(dirname($ruta) . "/");
}

function get_fileNameById($uploadId) {
    include './db.php';
    if ($uploadId) {
        $stmt_file = $db->prepare("SELECT source_name FROM upload_file WHERE id = ? and state = 1");
        $stmt_file->execute(array($uploadId));
        $row_file = $stmt_file->fetch(PDO::FETCH_ASSOC);
        return $row_file["source_name"];
    }
    return "";
}

function explora_ruta($ruta) {
    include './db.php';
    $cadena = "";
    $barra = "";
    $manejador = @dir($ruta);
    while ($recurso = $manejador->read()) {
        if ($ruta == getcwd() . '/fileRepository/' && !($recurso == ".." || $recurso == ".")) {
            $nombre = "$ruta$recurso";
            $stmt_file2 = $db->prepare("SELECT state FROM company WHERE path = ?;");
            $stmt_file2->execute(array($recurso));
            $row_file2 = $stmt_file2->fetch(PDO::FETCH_ASSOC);
            if ($row_file2["state"] == 1) {
                if (@is_dir($nombre)) {
                    $barra = "/";
                    $cadena .= "";
                } else {
                    $barra = "";
                    $cadena .= "";
                }
                if (@is_readable($nombre)) {
                    $cadena .= "<a href=\"" . $_SERVER["PHP_SELF"] .
                            "?una-ruta=$nombre$barra\"><img src='images/folder.png'/>$recurso$barra</a>";
                } else {
                    $cadena .= "$recurso$barra";
                }
                $cadena .= "<br />";
            }
        }
    }
    if (!($ruta == getcwd() . '/fileRepository/')) {
        if (file_exists($ruta)) {
            $files_aux = scandir($ruta);
            foreach ($files_aux as $file_aux) {
                if ($file_aux == "..") {
                    $nombre = "$ruta$file_aux";
                    if (@is_dir($nombre)) {
                        $barra = "/";
                        $cadena .= "";
                    } else {
                        $barra = "";
                        $cadena .= "";
                    }
                    if (@is_readable($nombre)) {
//                        $cadena .= "<a href=\"" . $_SERVER["PHP_SELF"] . "?una-ruta=$nombre$barra\"><img src='images/back.png'/></a>";
                        $cadena .= "<a href=http://jmsaludocupacionaleu.com/docserver/admfiles.php><img src='images/back.png'/></a>";
                    } else {
                        $cadena .= "$file_aux$barra";
                    }
                    $cadena .= "<br />";
                }
            }
            $files = array_diff($files_aux, array('..', '.'));
            if (count($files)) {
                foreach ($files as $file) {
                    $arrayFile[] = $file;
                }
                array_multisort($arrayFile, SORT_DESC, SORT_NUMERIC);
                foreach ($arrayFile as $ids) {
                    $uploadId = current(explode('.', $ids));
                    $stmt_file3 = $db->prepare("SELECT state FROM upload_file WHERE id = ?");
                    $stmt_file3->execute(array($uploadId));
                    $row_file3 = $stmt_file3->fetch(PDO::FETCH_ASSOC);
                    if ($uploadId && $row_file3["state"] == 1) {
                        $labelFile = get_fileNameById($uploadId);
                        $nombre = "$ruta$recurso";
                        if (@is_dir($nombre)) {
                            $barra = "/";
                            $cadena .= "";
                        } else {
                            $barra = "";
                            $cadena .= "";
                        }
                        if (@is_readable($nombre)) {
                            $cadena .= "<li class = 'mdl-list__item'><span class = 'mdl-list__item-primary-content'><i class = 'material-icons'>attach_file</i><a href =downloadFile.php?path=" . $ruta . "&filename=" . $labelFile . "&fileid=" . $uploadId . ">" . $labelFile . "</a></span><a href =downloadFile.php?path=" . $ruta . "&filename=" . $labelFile . "&fileid=" . $uploadId . "><i class='material-icons'>cloud_download</i></a></li>";
                        } else {
                            $cadena .= "$recurso$barra";
                        }
                    }
                }
            }
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
                ?>
            </span>
        </div>
    </body>
</html>

<?php
include './footer.php';
?>