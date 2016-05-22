<?php

include './db.php';

$username = $_POST["username"];
$password = $_POST["password"];


$stmt = $db->prepare("SELECT id FROM users WHERE username = ? AND pwd = ?");
$stmt->execute(array($username, $password));
$row_count = $stmt->rowCount();

if ($row_count > 0) {
    echo "1";
} else {
    http_response_code(401);
    echo "Usuario o contraseña incorrectos.";
}
?>

