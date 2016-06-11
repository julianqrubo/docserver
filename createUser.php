<?php

session_start();
include './db.php';
include './errors.php';

function validateConntentField($regex, $valor) {
    return preg_match($regex, $valor);
}

$companyId = filter_input(INPUT_POST, "companyId");
$pwd = filter_input(INPUT_POST, "pwd");
$isAdmin = 1;

if (empty($companyId)) {
    $companyId = NULL;
}
if (empty($pwd)) {
    $pwd = NULL;
}
if (isset($_POST["isAdmin"])) {
    $isAdmin = $_POST["isAdmin"];
}

$pwd_v2 = validateConntentField("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $pwd);

$stmt_getCompanyDocumentId = $db->prepare("SELECT documentId FROM company WHERE ID = ?");
$stmt_getCompanyDocumentId->execute(array($companyId));
$row_getCompanyDocumentId = $stmt_getCompanyDocumentId->fetch(PDO::FETCH_ASSOC);

try {
    if($pwd_v2) {
        $stmt = $db->prepare("INSERT INTO users (companyId,userName,pwd,isAdmin) VALUES (?, ?, ?, ?);");
        $stmt->execute(array($companyId, $row_getCompanyDocumentId['documentId'], $pwd, $isAdmin));
        $row = $stmt->rowCount();
    }
} catch (Exception $ex) {
    http_response_code(500);
    echo get_error($ex->getCode(), $ex->getMessage());
}
?>