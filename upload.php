<?php

session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
include './errors.php';
//Recibo el id de la empresa a la que le voy a cargar los files
$companyId = $_POST["companyId"];
$classifierId = $_POST["classifierId"];
if (empty($classifierId)) {
    $classifierId = NULL;
}
$stmt = $db->prepare("SELECT path FROM company WHERE id = ?");
$stmt->execute(array($companyId));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$path = "";

if ($row) {
    $path = getcwd() . '/fileRepository/' . $row["path"] . "/";
}

$target_dir = $path;
$resultMsg = "";

$upload_user = $_SESSION["__user__"];
$upload_source_name = NULL;
$upload_type = NULL;
$upload_size = NULL;
$upload_path = NULL;
$upload_extension = NULL;

if ($_FILES["fileToUpload"]["name"][0]) {
    echo "<h2 style='text-align: center'>Resultado de la operación</h2>
        <div class='demo-card-wide mdl-card mdl-shadow--2dp' style='margin-left: auto; margin-right: auto; margin-top: 30px; margin-bottom:auto; width: 600px'>
            <div style='text-align: left; margin-left: 20px; margin-right: 20px; margin-top: 20px; margin-bottom: 20px;'>
                <form id='uploadFiles-form'>
                    <div>";
    for ($i = 0; $i < count($_FILES["fileToUpload"]["name"]); $i++) {
        $upload_source_name = str_replace(" ", "", trim($_FILES["fileToUpload"]["name"][$i]));
        $upload_type = $_FILES["fileToUpload"]["type"][$i];
        $upload_size = $_FILES["fileToUpload"]["size"][$i];

        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
        $upload_extension = end(explode('.', $target_file));
        $upload_path = $target_dir;
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
            try {
                $db->beginTransaction();
                $stmt = $db->prepare("INSERT INTO upload_file (user,source_name,companyId,classifierId,type,size,upload_date,path,state) VALUES (?, ?, ?, ?, ?, ?, now(), ?, 1);");
                $stmt->execute(array($upload_user, $upload_source_name, $companyId, $classifierId, $upload_type, $upload_size, $upload_path));
                $insertId = $db->lastInsertId();
                $row = $stmt->rowCount();
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_dir . $insertId . "." . $upload_extension)) {
                    $resultMsg = "<p><font color='green'>El archivo " . basename($_FILES["fileToUpload"]["name"][$i]) . " ha sido cargado</font></p>";
                     $db->commit();
                } else {
                    $db->rollBack();
                    $resultMsg = "<p><font color='red'>Ha ocurrido un error cargando el archivo " . basename($_FILES["fileToUpload"]["name"][$i]) . "</font></p>";
                }
            } catch (Exception $exc) {
                echo $resultMsg;
                echo $exc->getMessage();
            }
        }
        echo $resultMsg;
    }
    echo "</div></form></div></div>";
}

include './footer.php';
?>