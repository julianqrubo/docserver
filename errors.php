<?php

$errors = array(23000=>"Ya existe un registro y no se permiten valores repetidos");
function get_error ($error, $msg){
    global $errors;
    if(isset($GLOBALS['errors'][$error])){
        return $GLOBALS['errors'][$error];
    }
    return $msg;
}

?>

