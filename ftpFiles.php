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
            .name		{float:left;width:250px;overflow:hidden;}
            .mime		{float:left;margin-left:10px;}
            .size		{float:right;}
            .bold		{font-weight:bold;}
            footer		{text-align:center;margin-top:20px;color:#808080;}
        </style>
    </head>

    <body>
        <h3 style="text-align: center;">Explorador de archivos</h3>
        <div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-left: auto; margin-right: auto; margin-top: 5%; margin-bottom: 5%; width: 600px;">
            <span class = "mdl-list__item-primary-content" style="margin-left: 5%; margin-right: 5%; margin-top: 5%; margin-bottom: 5%">
                <?php
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
                ?>
                <section>
                    <?php
                    // si no estamos en la raiz, permitimos volver hacia atras
                    if ($path != $path_base . $path_company . "/*")
                        echo "<div class='bold group'><a href='?path=" . $back . "'><img src='images/back.png'/></a></div>";
                    // devuelve el tipo mime de su extensión (desde PHP 5.3)
                    $finfo1 = finfo_open(FILEINFO_MIME_TYPE);
                    // devuelve la codificación mime del fichero (desde PHP 5.3)
                    $finfo2 = finfo_open(FILEINFO_MIME_ENCODING);
                    $folder = 0;
                    $file = 0;
                    # recorremos todos los archivos de la carpeta
                    foreach (glob($path) as $filename) {
                        $recurso = end(explode("/", $filename));
                        $fileMime = finfo_file($finfo1, $filename);
                        $fileEncoding = finfo_file($finfo2, $filename);
                        if ($fileMime == "directory") {
                            $folder+=1;
                            // mostramos la carpeta y permitimos pulsar sobre la misma
                            echo "<div class='directory group'>
				<a href='?path=" . $filename . "/*' class='name'><img src='images/folder.png'/>" . end(explode("/", $filename)) . "</a>
			</div>";
                        } else {
                            $file+=1;
                            // mostramos la información del archivo
                            echo "<div class='group'>
				<div class='size'>" . number_format(filesize($filename) / 1024, 2, ",", ".") . " Kb</div>
				<div class='name'><a href=downloadFTP.php?path=" . getcwd() . "/" . substr($path, 0, -2) . "&filename=" . $recurso . "><img src='images/file.png'/>$recurso</a></div>
			</div>";
                        }
                    }
                    finfo_close($finfo1);
                    finfo_close($finfo2);
                    ?>
            </span>
        </div>
        <footer>
            <?php echo $folder ?> carpeta/s y <?php echo $file ?> archivo/s
        </footer>
    </section>
</body>
</html>

<?php
include './footer.php';
?>