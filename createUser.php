<?php

session_start();
include './db.php';

$companyId = Null;
$name = "";
$lastName = "";
$userName = "";
$pwd = "";
$email = "";
$phone = "";
$isAdmin = 1;

if (isset($_POST["companyId"])) {
    $companyId = $_POST["companyId"];
}
if (isset($_POST["name"])) {
    $name = $_POST["name"];
}
if (isset($_POST["lastName"])) {
    $lastName = $_POST["lastName"];
}
if (isset($_POST["userName"])) {
    $userName = $_POST["userName"];
}
if (isset($_POST["pwd"])) {
    $pwd = $_POST["pwd"];
}
if (isset($_POST["email"])) {
    $email = $_POST["email"];
}
if (isset($_POST["phone"])) {
    $phone = $_POST["phone"];
}
if (isset($_POST["isAdmin"])) {
    $isAdmin = $_POST["isAdmin"];
}

try {
    $stmt = $db->prepare("INSERT INTO users (companyId,name,lastName,userName,pwd,email,phone,isAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->execute(array($companyId, $name, $lastName, $userName, $pwd, $email, $phone, $isAdmin));
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