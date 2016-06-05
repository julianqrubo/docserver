<?php

session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './db.php';

class Companies {

    public function findInfoCompany($infoCompany) {
        $stmt = $db->prepare("SELECT ID, name FROM company where state = 1 and lower(name) like '%".$infoCompany."%' or lowe(documentId) like '%".$infoCompany."%' order by name asc");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $row_cunter = $stmt->rowCount();

        $datos = array();
        foreach ($rows as $result) {
            $datos[] = array("id" => $row['ID'],
                "name" => $row['name']);
        }
        return $datos;
    }
}

?>