<?php
session_start();
include './db.php';
$username = "";
if (isset($_POST["username"])) {
    $username = $_POST["username"];
}
$password = "";
if (isset($_POST["username"])) {
    $password = $_POST["password"];
}
$stmt = $db->prepare("SELECT id, companyId, name, lastName, username, pwd, email, phone, isAdmin FROM users WHERE username = ? AND pwd = ?");
$stmt->execute(array($username, $password));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row > 0) {
    $_SESSION['__user__'] =  $row["id"];
    echo $row["id"];
} else {
    http_response_code(401);
    echo "Usuario o contraseña incorrectos.";
}
?>