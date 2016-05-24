<?php
    session_start();
    if (!isset($_SESSION["__user__"])) {
        header('Location: index.php');
        exit;
    }
    include './header.php';
    include './db.php';
?>

<h3 style="text-align: center;">Registro de empresa</h3>

<div class="demo-card-wide mdl-card mdl-shadow--2dp" style="width: 600px; margin-left: 30%; margin-right: 30%; margin-top: 5%;">
    <div style="text-align: left; margin-left: 5%">
        <form action="" id="createCompany-form">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="documentId" name="documentId" pattern="[a-z]+" maxlength="10">
                <label class="mdl-textfield__label" for="companyId">Número de documento</label>
                <span class="mdl-textfield__error">Solo se permiten números</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="name" name="name" pattern="[a-z]+" maxlength="30">
                <label class="mdl-textfield__label" for="name">Nombre</label>
                <span class="mdl-textfield__error">Solo se permiten letras minúsculas</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="address" name="address" pattern="[a-z]+" maxlength="30">
                <label class="mdl-textfield__label" for="address">Dirección</label>
                <span class="mdl-textfield__error">Dirección no permitida</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="phone" name="phone" pattern="/^([0-9\+\s\+\-])+$/" maxlength="15">
                <label class="mdl-textfield__label" for="phone">Teléfono</label>
                <span class="mdl-textfield__error">Teléfono incorrecto</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="path" name="path" pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/" maxlength="30">
                <label class="mdl-textfield__label" for="path">Nombre del directorio</label>
                <span class="mdl-textfield__error">Nombr de directorio no permitido</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="state" name="state" pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/" maxlength="40">
                <label class="mdl-textfield__label" for="state">Estado</label>
                <span class="mdl-textfield__error">Estado no permitido</span>
            </div>
            <div>
                <button id="insert-comapny-button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</div>

<?php
    include './footer.php';
?>