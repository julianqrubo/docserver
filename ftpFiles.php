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
            <span class = "mdl-list__item-primary-content" style="margin-left: 5%; margin-right: 5%; margin-top: 5%; margin-bottom: 5%">
                <?php
                // si no estamos en la raiz, permitimos volver hacia atras
                if ($path != $path_base . $path_company . "/*")
                    echo "<div class='bold group'><a href='?path=" . $back . "'><img src='images/back.png'/></a></div>";
                ?>
            </span>
        </div>
    </body>
</html>

<?php
include './footer.php';
?>