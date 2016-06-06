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
        <link type="text/css" rel="stylesheet" href="css/jquery-ui-1.8.4.custom.css" />
        <script src="js/jquery-2.2.4.js"></script>
        <script src="js/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui-1.8.4.custom.min.js"></script>
        <script type="text/javascript">
            /*$(function () {
                $("#companyId").autocomplete({
                    //source: 'ajax.php',
                    source: ('Jose', 'Luis', 'Maria'),
                    select: function (event, ui) {
                        $('#companyResult').slideUp('slow', function () {
                            $('#companyResult').html(
                                    '<h2>Detalles de usuario</h2>' + '<strong>Nombre: </strong>' + ui.item.name + '<br/>'
                                    );
                        });
                        $('#companyResult').slideDown('slow');
                    }
                });
            });*/
        </script>
        <title>Cargue de archivos</title>
    </head>
    <body>
        <h3 style="text-align: center;">Cargue de archivos</h3>
        <div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-left: auto; margin-right: auto; margin-top: 5%; width: 500px">
            <div style="text-align: center;">
                <form method="POST" action="upload.php" id="uploadFiles-form" enctype="multipart/form-data">
                    <div>
                        <input type="text" id="companyId" name="companyId" />
                    </div>
                    <div id="companyResult">

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