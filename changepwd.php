<?php

session_start();
$userid = $_SESSION["__user__"];
if (isset($userid)) {
    include './db.php';
    $current_password = "";
    if (isset($_POST["current_password"])) {
        $current_password = $_POST["current_password"];
    }
    $password = "";
    if (isset($_POST["password"])) {
        $password = $_POST["password"];
    }
    $repassword = "";
    if (isset($_POST["repassword"])) {
        $repassword = $_POST["repassword"];
    }
    $stmt = $db->prepare("SELECT pwd FROM users WHERE id = ?");
    $stmt->execute(array($userid));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        if ($row["pwd"] == $current_password) {
            if (strlen($password) > 5) {
                if ($password == $repassword) {
                    $stmt = $db->prepare("UPDATE users SET pwd=? WHERE id=?");
                    $stmt->execute(array($password, $userid));
                    $affected_rows = $stmt->rowCount();
                    echo $affected_rows;
                } else {
                    http_response_code(401);
                    echo "Las contraseñas no coinciden.";
                }
            } else {
                http_response_code(401);
                echo "Las contraseñas debe contener al menos 6 catacteres.";
            }
        } else {
            http_response_code(401);
            echo "La contraseña actual no es correcta.";
        }
    }
} else {
    http_response_code(401);
    echo "La sesión ha finalizado.";
}
?>