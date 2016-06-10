<?php

include './db.php';
$infoClassifier = filter_input(INPUT_GET, "q");

//este query sería pasandole el id de la empresa pero no se como pasarle el id de la empresa
//$stmt = $db->prepare("SELECT ID, name FROM classifier where companyId = ? state = 1 and lower(name) like '%" . $infoClassifier . "%' order by name asc");
$stmt = $db->prepare("SELECT ID, name FROM classifier where state = 1 and lower(name) like '%" . $infoClassifier . "%' order by name asc");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();
$datos = array();
foreach ($rows as $row) {
    $datos[] = array("id" => $row['ID'], "name" => $row['name']);
}
echo json_encode($datos);
?>