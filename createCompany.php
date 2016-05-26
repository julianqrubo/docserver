<?php

session_start();
include './db.php';
include './errors.php';

$documentId = filter_input(INPUT_POST, "documentId");
$name = filter_input(INPUT_POST, "name");
$address = Null;
$phone = Null;
$path = filter_input(INPUT_POST, "path");

if (empty($documentId)) {
    $documentId = NULL;
}
if (empty($name)) {
    $name = NULL;
}
if (isset($_POST["address"])) {
    $address = $_POST["address"];
}
if (isset($_POST["phone"])) {
    $phone = $_POST["phone"];
}
if (empty($path)) {
    $path = NULL;
}

try {
    $stmt = $db->prepare("INSERT INTO company (documentId,name,address,phone,path,state) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->execute(array($documentId, $name, $address, $phone, $path, 1));
    $row = $stmt->rowCount();
    if ($row) {
        echo "Se ingresaron los registros con exito";
    } else {
        echo "No se ingresaron los registros.";
    }
} catch (Exception $ex) {
    http_response_code(500);
    echo get_error($ex->getCode(), $ex->getMessage());
}
?>