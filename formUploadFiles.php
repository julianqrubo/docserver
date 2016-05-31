<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';

$stmt_cbox = $db->prepare("SELECT ID, name FROM company where state = 1 order by name asc");
$stmt_cbox->execute();
$rows_cbox = $stmt_cbox->fetchAll(PDO::FETCH_ASSOC);
$row_cunter_cbox = $stmt_cbox->rowCount();

$cboxCompany = "";
foreach ($rows_cbox as $id) {
    $cboxCompany .=" <option value='" . $id['ID'] . "'>" . $id['name'] . "</option>";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Cargue de archivos</title>
    </head>
    <body>
        <h3 style="text-align: center;">Cargue de archivos</h3>
        <div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-left: auto; margin-right: auto; margin-top: 5%; width: 500px">
            <div style="text-align: center;">
                <form method="POST" action="upload.php" id="uploadFiles-form" enctype="multipart/form-data">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="margin-left: auto; margin-right: auto; margin-top: 5%;">
                        <label class="mdl-textfield__label"><b>Empresa*</b></label>
                        <select id="companyId" name="companyId" class="mdl-textfield__input">
                            <option value=""></option>
                            <?php echo $cboxCompany; ?>
                        </select>
                    </div>
                    <div style="margin-left: auto; margin-right: auto; margin-top: 5%;">
                        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="multiple" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                        <input type="submit" value="Cargar archivo" name="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
include './footer.php';
?>