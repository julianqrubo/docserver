<?php

include './db.php';

$infoCompany = array();
$stmt = $db->prepare("SELECT ID, documentId, name, path FROM company order by name asc");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();

foreach ($rows as $row) {
    $infoCompany[] = array("id" => $row['ID'], "documentId" => $row['documentId'], "name" => $row['name'], "path" => $row['path']);
}
echo json_encode($infoCompany);
?>