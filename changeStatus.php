<?php

include './db.php';
$ids = [];

if (isset($_POST["ids"])) {
    $ids = explode(",", $_POST["ids"]);
}
$params = "";

foreach ($ids as $id) {
    // Obtengo el state by id
    $stmt = $db->prepare("select state from company where ID = ?;");
    $stmt->execute(array($id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($row['state'] == 2){
        $queryUpd = "update company set state = 1 where ID = ?;";
    }else{
        $queryUpd = "update company set state = 2 where ID = ?;";
    }
    $stmtUpd = $db->prepare($queryUpd);
    $stmtUpd->execute($id);
    $affected_rowsUpd = $stmtUpd->rowCount();
    echo $affected_rowsUpd;
}

echo "$params";
?>