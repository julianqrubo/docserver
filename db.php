<?php
    $database_ip = '192.168.1.37';
    $database_name = 'docserverjm';
    $database_pwd = 'qwerty';
    $db = new PDO('mysql:host='.$database_ip.';dbname='.$database_name.';charset=utf8', 'root', $database_pwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
