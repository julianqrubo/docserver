<?php

session_start();
include './db.php';
include './errors.php';

function validateConntentField($regex, $valor) {
    return preg_match($regex, $valor);
}

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

$name_v2 = validateConntentField("/^[a-zñáéíóú\s]{4,30}$/", $name);
$lastName_v2 = validateConntentField("/^[a-zñáéíóú\s]{4,30}$/", $lastName);
$userName_v2 = validateConntentField("/^[a-z\d_.]{4,20}$/", $userName);
$pwd_v2 = validateConntentField("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $pwd);
if($email){
    $email_v2 = validateConntentField("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email);
}else{
    $email_v2 = TRUE;
}

if($phone){
    $phone_v2 = validateConntentField("/^\d*$/", $phone);
}else{
    $phone_v2 = TRUE;
}

try {
    if($name_v2 && $lastName_v2 && $userName_v2 && $pwd_v2 && $email_v2 && $phone_v2) {
        $stmt = $db->prepare("INSERT INTO users (companyId,name,lastName,userName,pwd,email,phone,isAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->execute(array($companyId, $name, $lastName, $userName, $pwd, $email, $phone, $isAdmin));
        $row = $stmt->rowCount();
    }
} catch (Exception $ex) {
    http_response_code(500);
    echo get_error($ex->getCode(), $ex->getMessage());
}
?>