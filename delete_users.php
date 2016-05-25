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

// Elimino los usuario de la empresa que se va a eliminar
$queryUsr = "delete from users where ID in (" . join(",", $params) . ");";
$stmtUsr = $db->prepare($queryUsr);
$stmtUsr->execute($ids);
$affected_rowsUsr = $stmtUsr->rowCount();
echo $affected_rowsUsr;
?>