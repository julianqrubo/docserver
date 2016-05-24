<?php
    session_start();
    include './db.php';
    $documentId = NULL;
    $name = "";
    $address = "";
    $phone = "";
    $path = "";
    
    if (isset($_POST["documentId"])) {  $documentId = $_POST["documentId"];   }
    if (isset($_POST["name"])) {  $name = $_POST["name"];   }
    if (isset($_POST["address"])) {  $address = $_POST["address"];   }
    if (isset($_POST["phone"])) {  $phone = $_POST["phone"];   }
    if (isset($_POST["path"])) {  $path = $_POST["path"];   }
    
    $stmt = $db->prepare("INSERT INTO company (documentId,name,address,phone,path,state) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->execute(array($documentId, $name, $address, $phone, $path, 1));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        console.log("Se ingresaron los registros con exito");
        echo "Se ingresaron los registros con exito";
    } else {
        console.log("No se ingresaron los registros.");
        echo "No se ingresaron los registros.";
    }
?>