<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';

$stmt = $db->prepare("SELECT id, companyId, name, lastName, username, pwd, email, phone, isAdmin FROM company WHERE username = ? AND pwd = ?");
$stmt->execute(array($username, $password));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<h3 style="text-align: center;">Registro de usuario</h3>

<div class="demo-card-wide mdl-card mdl-shadow--2dp" style="width: 600px; margin-left: 30%; margin-right: 30%; margin-top: 5%;">
    <div style="text-align: left; margin-left: 5%">
        <form action="createUser.php" id="createUser-form">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="companyId" name="companyId" pattern="^\d*$">
                <label class="mdl-textfield__label" for="companyId">Empresa</label>
                <span class="mdl-textfield__error">Solo números</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="name" name="name" pattern="[a-z\s]*$" maxlength="30">
                <label class="mdl-textfield__label" for="name">Nombre de la persona</label>
                <span class="mdl-textfield__error">Solo letras minúsculas</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="lastName" name="lastName" pattern="[a-z\s]*$" maxlength="30">
                <label class="mdl-textfield__label" for="lastName">Apellidos</label>
                <span class="mdl-textfield__error">Solo letras minúsculas</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="userName" name="userName" pattern="[a-z\.]+" maxlength="20">
                <label class="mdl-textfield__label" for="userName">Nombe de usuario</label>
                <span class="mdl-textfield__error">Solo se permiten minúsculas y puntos (.)</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" id="pwd" name="pwd">
                <label class="mdl-textfield__label" for="pwd">Contraseña</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="email" name="email" pattern="([a-z]+[a-z1-9._-]*)@{1}([a-z1-9\.]{2,})\.([a-z]{2,3})$" maxlength="40">
                <label class="mdl-textfield__label" for="email">Email</label>
                <span class="mdl-textfield__error">Correo electrónico no permitido</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="phone" name="phone" pattern="^\d*$" maxlength="15">
                <label class="mdl-textfield__label" for="phone">Teléfono</label>
                <span class="mdl-textfield__error">Solo números</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="isAdmin" name="isAdmin" pattern="^\d*$" maxlength="1">
                <label class="mdl-textfield__label" for="isAdmin">¿Es administrador?</label>
                <span class="mdl-textfield__error">Solo números</span>
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