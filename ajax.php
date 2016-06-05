<?php

include_once './companiesAutoComplete.class.php';

$company = new Companies();

echo json_encode($company->findInfoCompany($_GET['term']));

?>