<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
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
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="companyId_raw" name="companyId_raw">
                        <input type="hidden" id="companyId" name="companyId">
                        <label class="mdl-textfield__label" for="companyId">Empresa*</label>
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