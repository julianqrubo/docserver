<?php

include './db.php';
$infoCompany = "%".filter_input(INPUT_GET, "q")."%";
$stmt = $db->prepare("SELECT ID, name, documentId FROM company where state = 1 and lower(name) like lower(?) or lower(documentId) like lower(?) order by name asc");
$stmt->execute(array($infoCompany, $infoCompany));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();
$datos = array();
foreach ($rows as $row) {
    $datos[] = array("id" => $row['ID'], "name" => $row['name'], "documentId" => $row['documentId']);
}
echo json_encode($datos);
?>