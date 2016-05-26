<?php

session_start();
include './db.php';
include './errors.php';

$companyId = filter_input(INPUT_POST, "companyId");
$name = filter_input(INPUT_POST, "name");
$lastName = filter_input(INPUT_POST, "lastName");
$userName = filter_input(INPUT_POST, "userName");
$pwd = filter_input(INPUT_POST, "pwd");
$email = Null;
$phone = Null;
$isAdmin = 1;

if (empty($companyId)) {
    $companyId = NULL;
}
if (empty($name)) {
    $name = NULL;
}
if (empty($lastName)) {
    $lastName = NULL;
}
if (empty($userName)) {
    $userName = NULL;
}
if (empty($pwd)) {
    $pwd = NULL;
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
        echo "No se ingresaron los registros";
    }
} catch (Exception $ex) {
    http_response_code(500);
    echo get_error($ex->getCode(), $ex->getMessage());
}
?>