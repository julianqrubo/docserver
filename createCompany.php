<?php

session_start();
include './db.php';
include './errors.php';

function validateConntentField($regex, $valor) {
    return preg_match($regex, $valor);
}

$stmt_getCompanyId = $db->prepare("SELECT AUTO_INCREMENT nextId FROM information_schema.TABLES WHERE TABLE_NAME = 'company';");
$stmt_getCompanyId->execute();
$row_getCompanyId = $stmt_getCompanyId->fetch(PDO::FETCH_ASSOC);

$documentId = filter_input(INPUT_POST, "documentId");
$name = filter_input(INPUT_POST, "name");
$address = NULL;
$phone = NULL;
$email = NULL;
$path = filter_input(INPUT_POST, "path");

if (empty($documentId)) {
    $documentId = "jmso_".$row_getCompanyId["nextId"];
    $vDocumentId = TRUE;
}else{
    $documentId = trim($documentId);
    $vDocumentId = validateConntentField("/^\d*$/", $documentId);
}
if (empty($name)) {
    $name = NULL;
}else{
    $name = trim($name);
}
if (isset($_POST["address"])) {
    $address = $_POST["address"];
}
if (isset($_POST["phone"])) {
    $phone = $_POST["phone"];
}
if (isset($_POST["email"])) {
    $email = $_POST["email"];
}
if (empty($path)) {
    $path = NULL;
}

$vName = validateConntentField("/^[a-zA-ZñÑáÁéÉíÍóÓúÚ\d\s]{4,100}$/", $name);
if ($phone) {
    $phone = trim($phone);
    $vPhone = validateConntentField("/^\d*$/", $phone);
} else {
    $vPhone = TRUE;
}
if ($email) {
    $email = trim($email);
    $vEmail = validateConntentField("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email);
} else {
    $vEmail = TRUE;
}
$vPath = validateConntentField("/^[a-z\d_]*$/", $path);

try {
    if ($vDocumentId && $vName && $vPhone && $vEmail && $vPath) {
        $stmt = $db->prepare("INSERT INTO company (documentId,name,address,phone,email,path,state) VALUES (?, ?, ?, ?, ?, ?, ?);");
        $stmt->execute(array($documentId, strtoupper($name), $address, $phone, $email, trim($path), 1));
        $row = $stmt->rowCount();
    }
} catch (Exception $ex) {
    http_response_code(500);
    echo get_error($ex->getCode(), $ex->getMessage());
}
?>