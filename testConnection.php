<?php

include './db.php';
$query = "select count(*) from company;";
$stmt = $db->prepare($queryUsr);
$stmt ->execute();
$affected_rows = $stmt->rowCount();
echo $affected_rows;

?>