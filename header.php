<?php
//Para ponerlo en producción debe poner $mode = ".min";
$mode = "";

$userName = $_SESSION["__username__"];
$isadmin = $_SESSION['__isadmin__'];
$dialogs = "";
?>

<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Repositorio de archivos">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
        <title>Repositorio de archivos<?php echo $_SERVER["REQUEST_URI"] ?></title>

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
        <script src="js/dialog-polyfill.js"></script>
        <link rel="stylesheet" href="css/dialog-polyfill.css">
    </head>

    <body>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <!-- Title -->
                    <span class="mdl-layout-title"><?php echo $userName; ?></span>
                    <!-- Add spacer, to align navigation to the right -->
                    <div class="mdl-layout-spacer"></div>
                    <!-- Navigation. We hide it in small screens. -->
                    <nav class="mdl-navigation mdl-layout--large-screen-only">
                        <a class="mdl-navigation__link" href="#" id="change-pwd">Cambiar contraseña</a>
                        <a class="mdl-navigation__link" href="logout.php">Cerrar sesión</a>
                    </nav>
                </div>
            </header>
            <div class="mdl-layout__drawer">
                <span class="mdl-layout-title">Menú de opciones</span>
                <nav class="mdl-navigation">
                    <?php if ($isadmin == 1) { ?>
                        <a class="mdl-navigation__link" href="companies.php">Empresas</a>
                        <a class="mdl-navigation__link" href="users.php">Usuarios</a>
                        <!--<a class="mdl-navigation__link" href="classifier.php">Clasificadores</a>-->
                        <!--<a class="mdl-navigation__link" href="formUploadFiles.php">Cargue de archivos</a>-->
                        <!--<a class="mdl-navigation__link" href="formDeleteFiles.php">Eliminación de Archivos</a>-->
                        <!--<a class="mdl-navigation__link" href="admfiles.php">Explorador de Archivos</a>-->
                        <a class="mdl-navigation__link" href="ftpFilesPages.php">Archivos</a>
                    <?php } else { ?>
                        <!--<a class="mdl-navigation__link" href="files.php">Archivos</a>-->
                        <a class="mdl-navigation__link" href="ftpFilesPages.php">Archivos</a>
                    <?php } ?>
                </nav>
            </div>
            <main class="mdl-layout__content" style="overflow-y: scroll; ">
                <div class="page-content">