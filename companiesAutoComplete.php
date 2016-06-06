<?php

include './db.php';
$infoCompany = filter_input(INPUT_GET, "q");
$stmt = $db->prepare("SELECT ID, name FROM company where state = 1 and lower(name) like '%" . $infoCompany . "%' or lower(documentId) like '%" . $infoCompany . "%' order by name asc");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();
$datos = array();
foreach ($rows as $row) {
    $datos[] = array("id" => $row['ID'], "name" => $row['name']);
}
echo json_encode($datos);
?>