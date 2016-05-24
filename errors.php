<?php

function get_error ($error, $msg){
    $errors = array(23000=>"Ya existe un registro y no se permiten valores repetidos");
    if(isset($errors[$error])){
        return $errors[$error];
    }
    return $msg;
}

?>

