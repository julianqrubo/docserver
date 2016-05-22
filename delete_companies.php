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
$query = "DELETE FROM company WHERE ID IN (" . join(",", $params) . ")";
$stmt = $db->prepare($query);
$stmt->execute($ids);
$affected_rows = $stmt->rowCount();
echo $affected_rows;
?>