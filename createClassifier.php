<?php

session_start();
include './db.php';
include './errors.php';

function validateConntentField($regex, $valor) {
    return preg_match($regex, $valor);
}

$companyId = filter_input(INPUT_POST, "companyId");
$classifier = filter_input(INPUT_POST, "name");

if (empty($companyId)) {
    $companyId = NULL;
}
if (empty($classifier)) {
    $classifier = NULL;
}else{
    $classifier = trim($classifier);
}

$vClassifier = validateConntentField("/^[a-zñ\d_]*$/", $classifier);

try {
    if($vClassifier) {
        $stmt = $db->prepare("INSERT INTO classifier (companyId,name,state) VALUES (?, ?, 1);");
        $stmt->execute(array($companyId, $classifier));
        $row = $stmt->rowCount();
    }
} catch (Exception $ex) {
    http_response_code(500);
    echo get_error($ex->getCode(), $ex->getMessage());
}
?>