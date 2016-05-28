<?php

session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
//Recibo el id de la empresa a la que le voy a cargar los files
$companyId = $_POST["companyId"];
$stmt = $db->prepare("SELECT path FROM company WHERE id = ?");
$stmt->execute(array($companyId));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$path = "";

if ($row) {
    $path = getcwd() . '/fileRepository/' . $row["path"] . "/";
}

$target_dir = $path;
$resultMsg = "";

// Variables para insertar en upload_file
$upload_user = $_SESSION['__id__'];
$source_name = "";
if ($_FILES["fileToUpload"]["name"][0]) {
    $source_name = $_FILES["fileToUpload"]["name"][0];
}


if ($_FILES["fileToUpload"]["name"][0]) {
    echo "<div class='demo-card-wide mdl-card mdl-shadow--2dp' style='margin-left: auto; margin-right: auto; margin-top: 30px; margin-bottom:auto; width: 600px'>
            <h2 style='text-align: center'>Resultado de la operación</h2>
            <div style='text-align: left; margin-left: 20px; margin-right: 20px'>
                <form id='uploadFiles-form'>
                    <div>";
    for ($i = 0; $i < count($_FILES["fileToUpload"]["name"]); $i++) {
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
        $uploadOk = 1;

        if (file_exists($target_file)) {
            $resultMsg = "<p><font color='red'>El archivo " . basename($_FILES["fileToUpload"]["name"][$i]) . " ya existe</font></p>";
            $uploadOk = 0;
        } else {
            $archivocreado = mkdir($target_dir);
            $uploadOk = 1;
        }
        if ($_FILES["fileToUpload"]["size"][$i] > 5000000) {
            $resultMsg = "<p><font color='red'>El archivo " . basename($_FILES["fileToUpload"]["name"][$i]) . " es muy pesado</font></p>";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            $resultMsg = "<p><font color='red'>El archivo " . basename($_FILES["fileToUpload"]["name"][$i]) . " no fue cargado</font></p>";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                // Acá se inserta en la tabla upload_file
                $resultMsg = "<p><font color='green'>El archivo " . basename($_FILES["fileToUpload"]["name"][$i]) . " ha sido cargado</font></p>";
            } else {
                $resultMsg = "<p><font color='red'>Ha ocurrido un error cargando el archivo " . basename($_FILES["fileToUpload"]["name"][$i]) . "</font></p>";
            }
        }
        echo $resultMsg;
    }
    echo "</div></form></div></div>";
}

include './footer.php';
?>