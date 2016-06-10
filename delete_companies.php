<?php

include './db.php';
$ids = [];
if (isset($_POST["ids"])) {
    $ids = explode(",", $_POST["ids"]);
}
$params = "";
foreach ($ids as $id) {
    $params[] = "?";
}

// Elimino los usuarios de la empresa que se va a eliminar
$queryUsr = "delete from users where companyId in (" . join(",", $params) . ");";
$stmtUsr = $db->prepare($queryUsr);
$stmtUsr->execute($ids);
$affected_rowsUsr = $stmtUsr->rowCount();
echo $affected_rowsUsr;

//Inactivo los clasificadores de la empresa
$queryUpdClass = "update classifier set state = 2 where companyId = ?;";
$stmtUpdClass = $db->prepare($queryUpdClass);
$stmtUpdClass->execute(array($id));
$affected_rowsUpdClass = $stmtUpdClass->rowCount();
echo $affected_rowsUpdClass;

// Elimino las empresas
$query = "DELETE FROM company WHERE ID IN (" . join(",", $params) . ")";
$stmt = $db->prepare($query);
$stmt->execute($ids);
$affected_rows = $stmt->rowCount();
echo $affected_rows;
?>