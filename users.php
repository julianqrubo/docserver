<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
$stmt = $db->prepare("SELECT u.ID ID, c.name companyName, u.userName userName, u.isAdmin isAdmin FROM users u, company c where u.companyId = c.ID order by isAdmin asc, c.name asc, userName asc");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();
?>

<h3 style="text-align: center;">Usuarios</h3>

<div style="width: 900px; margin: auto;">
    <div style="text-align: right; padding-bottom: 20px;">
        <button id="create-users-button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
            Crear
        </button>
        <button id="delete-users-button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
            Eliminar
        </button>
    </div>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 900px;" id="users-data-table">
        <thead>
            <tr>
                <th>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="users-table-header">
                        <input type="checkbox" id="users-table-header" class="mdl-checkbox__input" />
                    </label>
                </th>
                <th class="mdl-data-table__cell--non-numeric">Empresa</th>
                <th class="mdl-data-table__cell--non-numeric">Usuario</th>
                <th class="mdl-data-table__cell--non-numeric">¿Es administrador?</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $row) {
                ?>
                <tr>
                    <td>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="users_row_<?php echo $row['ID']; ?>">
                            <input type="checkbox" id="users_row_<?php echo $row['ID']; ?>" class="mdl-checkbox__input" />
                        </label>
                    </td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["companyName"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["userName"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["isAdmin"] == 1 ? '<i class="material-icons">done</i>' : '<i class="material-icons">clear</i>'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="padding: 10px; text-align: center; color: #444;"><?php echo $row_cunter; ?> registros encontrados</div>
</div>
<?php

$dialogs = <<<EOD
<dialog id="create-users-dialog" class="mdl-dialog" action="createUser.php" style="width: 500px;">
    <h3 style="text-align: center;">Registro de usuario</h3>
    <form action="createUser.php" id="createUser-form">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="companyId_raw" name="companyId_raw">
            <input type="hidden" id="companyId" name="companyId">
            <label class="mdl-textfield__label" for="companyId"><b>Empresa*</b></label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="password" id="pwd" name="pwd" maxlength="25" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
            <label class="mdl-textfield__label" for="pwd"><b>Contraseña*</b></label>
            <span class="mdl-textfield__error">La contraseña debe tener al menos una letra mayúscula, al menos una letra minúscula, al menos un número o caracter especial, la longitud debe ser como mínimo de 8 caracteres.</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <label class="mdl-textfield__label"><b>¿Es administrador?*</b></label>
            <select id="isAdmin" name="isAdmin" class="mdl-textfield__input">
                <option value=2>No</option>
                <option value=1>Si</option>
            </select>
        </div>
        <div>
            <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect okCreate-button">Crear</button>
            <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent closeCreate-button">Cancelar</button>
        </div>
    </form>
</dialog>

<dialog id="delete-users-dialog" class="mdl-dialog" action="delete_users.php" style="width: 500px">
    <h3 class="mdl-dialog__title">Eliminar</h3>
    <div class="mdl-dialog__content">
        <p>
            Realmente desea eliminar los registros seleccionados?
        </p>
    </div>

    <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="display: none;"></div>

    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent close-button">Cancelar</button>
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect ok-button" >Eliminar</button>
    </div>
</dialog>
EOD;
        ?>
<?php
include './footer.php';
?>