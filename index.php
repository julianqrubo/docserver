<?php
//Para ponerlo en producción debe poner $mode = ".min";
$mode = "";
?>
<!doctype html>
<html lang="en" style="background: rgb(63,81,181)">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Repositorio de archivos">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <title>Repositorio de archivos <?php echo $_SERVER["REQUEST_URI"] ?></title>

        <!-- Add to homescreen for Chrome on Android -->
        <meta name="mobile-web-app-capable" content="yes">
        <link rel="icon" sizes="192x192" href="images/android-desktop.png">

        <!-- Add to homescreen for Safari on iOS -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Software de historias cl&iacute;nicas">
        <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

        <!-- Tile icon for Win8 (144x144 + tile color) -->
        <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
        <meta name="msapplication-TileColor" content="#3372DF">

        <link rel="shortcut icon" href="images/favicon.png">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.indigo-pink.min.css" />
        <link rel="stylesheet" href="css/styles.css">
    </head>

    <body>
        <div style="margin-left: auto; margin-right: auto; margin-top: 2%; text-align: center">
            <h3 style="text-align: center"><b>Repositorio de archivos<br><font color = "#33cc33">J</font><font color = "#00ccff">M</font>Salud Ocupacional</b></h3>
            <img src='images/logoJM.png'/>
        </div>
        <div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-left: auto; margin-right: auto; margin-top: 1%; margin-bottom: 5%">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">Inicio de sesión</h2>
            </div>

            <div style="text-align: center;">
                <form action="login.php" id="sigin-form">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <!--<input class="mdl-textfield__input" type="text" id="username" name="username" pattern="[A-Za-z\.@]+">-->
                        <input class="mdl-textfield__input" type="text" id="username" name="username">
                        <label class="mdl-textfield__label" for="username">Nombre de usuario</label>
                        <!--<span class="mdl-textfield__error">Solo se permiten letras, puntos (.) o el signo de arroba (@)</span>-->
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="password" id="password" name="password">
                        <label class="mdl-textfield__label" for="password">Contraseña</label>
                    </div>
                </form>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="sigin">
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>

        <div id="status-snackbar" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <script src="js/material<?php echo $mode; ?>.js"></script>
        <script src="js/jquery-2.2.4<?php echo $mode; ?>.js"></script>
        <script src="js/logic.js"></script>
    </body>
</html>