<?php
    $database_ip = 'localhost';
    $database_name = 'docserverjm';
    $database_usr = 'root';
    $database_pwd = 'shareppy';
    $db = new PDO('mysql:host='.$database_ip.';dbname='.$database_name.';charset=utf8',$database_usr, $database_pwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>