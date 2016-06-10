<?php

include './db.php';
$ids = [];

if (isset($_POST["ids"])) {
    $ids = explode(",", $_POST["ids"]);
}
foreach ($ids as $id) {
    //Inactivo el clasificador
    $queryUpd = "update classifier set state = 2 where ID = ?;";
    $stmtUpd = $db->prepare($queryUpd);
    $stmtUpd->execute(array($id));
    $affected_rowsUpd = $stmtUpd->rowCount();
    echo $affected_rowsUpd;
    
    //Inactivo los documentos del clasificador
    $queryUpd2 = "update upload_file set state = 2 where classifierId = ?;";
    $stmtUpd2 = $db->prepare($queryUpd2);
    $stmtUpd2->execute(array($id));
    $affected_rowsUpd2 = $stmtUpd2->rowCount();
    echo $affected_rowsUpd2;
}
?>