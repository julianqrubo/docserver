<?php

include './db.php';
$ids = [];

if (isset($_POST["ids"])) {
    $ids = explode(",", $_POST["ids"]);
}
foreach ($ids as $id) {
    // Cambio el estado a los archivos para que no se muestren
    $queryUpd = "update upload_file set state = 2 where id = ?;";
    $stmtUpd = $db->prepare($queryUpd);
    $stmtUpd->execute(array($id));
    $affected_rowsUpd = $stmtUpd->rowCount();
    echo $affected_rowsUpd;
}
?>