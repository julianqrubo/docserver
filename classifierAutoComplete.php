<?php

include './db.php';
$companyId = filter_input(INPUT_GET, "companyId");
$infoClassifier = "%".filter_input(INPUT_GET, "q")."%";

$stmt = $db->prepare("SELECT ID, name FROM classifier where companyId = ? and state = 1 and lower(name) like lower(?) order by name asc");
$stmt->execute(array($companyId, $infoClassifier));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();
$datos = array();
foreach ($rows as $row) {
    $datos[] = array("id" => $row['ID'], "name" => $row['name']);
}
echo json_encode($datos);
?>