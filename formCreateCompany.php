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
    <div style="text-align: left; margin: 5%">
        <form action="createCompany.php" id="createCompany-form">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
                <input class="mdl-textfield__input" type="text" id="documentId" name="documentId" pattern="^\d*$" maxlength="10">
                <label class="mdl-textfield__label" for="companyId">NIT de la empresa</label>
                <span class="mdl-textfield__error">Solo números</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
                <input class="mdl-textfield__input" type="text" id="name" name="name" pattern="[a-z\.s]+" maxlength="30">
                <label class="mdl-textfield__label" for="name">Nombre de le empresa</label>
                <span class="mdl-textfield__error">Solo letras minúsculas</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
                <input class="mdl-textfield__input" type="text" id="address" name="address" pattern="[a-z1-9\s]*$" maxlength="30">
                <label class="mdl-textfield__label" for="address">Dirección de empresa</label>
                <span class="mdl-textfield__error">Solo letras minúsculas y números</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
                <input class="mdl-textfield__input" type="text" id="phone" name="phone" pattern="^\d*$" maxlength="15">
                <label class="mdl-textfield__label" for="phone">Teléfono de empresa</label>
                <span class="mdl-textfield__error">Solo números</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
                <input class="mdl-textfield__input" type="text" id="path" name="path" pattern="[a-z]*$" maxlength="30">
                <label class="mdl-textfield__label" for="path">Nombre del directorio</label>
                <span class="mdl-textfield__error">Solo letras minúsculas</span>
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