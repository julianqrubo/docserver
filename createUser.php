<?php
    session_start();
    if (!isset($_SESSION["__user__"])) {
        header('Location: index.php');
        exit;
    }
    include './header.php';
    include './db.php';
?>

<h3 style="text-align: center;">Registro de usuario</h3>

<div class="demo-card-wide mdl-card mdl-shadow--2dp" style="width: 600px; margin-left: 30%; margin-right: 30%; margin-top: 5%;">
    <div style="text-align: left; margin-left: 5%">
        <form action="" id="createUser-form">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="companyId" name="companyId" pattern="[a-z]+">
                <label class="mdl-textfield__label" for="companyId">Empresa</label>
                <span class="mdl-textfield__error">Solo se permiten letras minúsculas</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="name" name="name" pattern="[a-z]+" maxlength="30">
                <label class="mdl-textfield__label" for="name">Nombres</label>
                <span class="mdl-textfield__error">Solo se permiten letras minúsculas</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="lastName" name="lastName" pattern="[a-z]+" maxlength="30">
                <label class="mdl-textfield__label" for="lastName">Apellidos</label>
                <span class="mdl-textfield__error">Solo se permiten letras minúsculas</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="userName" name="userName" pattern="[A-Za-z\.]+" maxlength="20">
                <label class="mdl-textfield__label" for="userName">Nombe de usuario</label>
                <span class="mdl-textfield__error">Solo se permiten letras, puntos (.)</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" id="pwd" name="pwd">
                <label class="mdl-textfield__label" for="pwd">Contraseña</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="email" name="email" pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/" maxlength="40">
                <label class="mdl-textfield__label" for="email">Email</label>
                <span class="mdl-textfield__error">Correo electrónico no permitido</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="phone" name="phone" pattern="/^([0-9\+\s\+\-])+$/" maxlength="15">
                <label class="mdl-textfield__label" for="phone">Teléfono</label>
                <span class="mdl-textfield__error">Teléfono incorrecto</span>
            </div>
            <div>
                <button id="insert-user-button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</div>

<?php
    include './footer.php';
?>