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
    $stmt = $db->prepare("SELECT u.id, u.companyId, u.name, u.lastName, u.username, u.pwd, u.email, u.phone, u.isAdmin FROM users u, company c WHERE u.companyId = c.ID and c.state = 1 and username = ? AND pwd = ?");
    $stmt->execute(array($username, $password));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $_SESSION['__user__'] =  $row["id"];
        $_SESSION['__name__'] =  $row["name"];
        $_SESSION['__lastname__'] =  $row["lastName"];
        $_SESSION['__username__'] =  $row["username"];
        $_SESSION['__email__'] =  $row["email"];
        $_SESSION['__phone__'] =  $row["phone"];
        $_SESSION['__isadmin__'] =  $row["isAdmin"];
        $_SESSION['__company__'] =  $row["companyId"];
        echo $row["id"]." -- ".$row["name"]."----".$_SESSION['__user__'];
    } else {
        http_response_code(401);
        echo "Credenciales incorrectas o usuario inactivo";
    }
?>