<?php

session_start();
include './db.php';
$documentId = NULL;
$name = "";
$address = "";
$phone = "";
$path = "";

if (isset($_POST["documentId"])) {
    $documentId = $_POST["documentId"];
}
if (isset($_POST["name"])) {
    $name = $_POST["name"];
}
if (isset($_POST["address"])) {
    $address = $_POST["address"];
}
if (isset($_POST["phone"])) {
    $phone = $_POST["phone"];
}
if (isset($_POST["path"])) {
    $path = $_POST["path"];
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
    echo $ex->getMessage();
}
?>