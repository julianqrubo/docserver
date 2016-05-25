<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
$stmt = $db->prepare("SELECT u.ID ID, c.name companyName, u.name name, u.lastName lastName, u.userName userName, u.email email, c.phone phone, u.isAdmin isAdmin FROM users u, company c where u.companyId = c.ID order by isAdmin asc, userName asc");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();

$stmt_cbox = $db->prepare("SELECT ID, name FROM company where state = 1 order by name asc");
$stmt_cbox->execute();
$rows_cbox = $stmt_cbox->fetchAll(PDO::FETCH_ASSOC);
$row_cunter_cbox = $stmt_cbox->rowCount();

$cboxCompany = "";
foreach ($rows_cbox as $id) {
    $cboxCompany .=" <option value='".$id['ID']."'>".$id['name']."</option>";
}
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
                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                <th class="mdl-data-table__cell--non-numeric">Apellido</th>
                <th class="mdl-data-table__cell--non-numeric">Usuario</th>
                <th class="mdl-data-table__cell--non-numeric">Correo</th>
                <th class="mdl-data-table__cell--non-numeric">Teléfono</th>
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
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["name"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["lastName"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["userName"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["email"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["phone"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["isAdmin"] == 1 ? '<i class="material-icons">done</i>' : '<i class="material-icons">clear</i>'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="padding: 10px; text-align: center; color: #444;"><?php echo $row_cunter; ?> registros encontrados</div>
</div>

<dialog id="create-users-dialog" class="mdl-dialog" action="createUser.php" style="width: 500px;">
    <h3 style="text-align: center;">Registro de usuario</h3>
    <form action="createUser.php" id="createUser-form">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <!--<input class="mdl-textfield__input" type="text" id="companyId" name="companyId" pattern="^\d*$">
            <label class="mdl-textfield__label" for="companyId">Empresa</label>
            <span class="mdl-textfield__error">Solo números</span>  -->
            <label class="mdl-textfield__label">Empresa</label>
            <select id="companyId" name="companyId" class="mdl-textfield__input">
                <?php echo $cboxCompany; ?>
            </select>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="name" name="name" pattern="[a-z\s]*$" maxlength="30">
            <label class="mdl-textfield__label" for="name">Nombre de la persona</label>
            <span class="mdl-textfield__error">Solo letras minúsculas</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="lastName" name="lastName" pattern="[a-z\s]*$" maxlength="30">
            <label class="mdl-textfield__label" for="lastName">Apellidos</label>
            <span class="mdl-textfield__error">Solo letras minúsculas</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="userName" name="userName" pattern="[a-z\.]+" maxlength="20">
            <label class="mdl-textfield__label" for="userName">Nombre de usuario</label>
            <span class="mdl-textfield__error">Solo letras minúsculas y puntos (.)</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="password" id="pwd" name="pwd">
            <label class="mdl-textfield__label" for="pwd">Contraseña</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="email" name="email" pattern="([a-z]+[a-z1-9._-]*)@{1}([a-z1-9\.]{2,})\.([a-z]{2,3})$" maxlength="40">
            <label class="mdl-textfield__label" for="email">Email</label>
            <span class="mdl-textfield__error">Correo electrónico no permitido</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="phone" name="phone" pattern="^\d*$" maxlength="15">
            <label class="mdl-textfield__label" for="phone">Teléfono</label>
            <span class="mdl-textfield__error">Solo números</span>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <!--<input class="mdl-textfield__input" type="text" id="isAdmin" name="isAdmin" pattern="^\d*$" maxlength="1">
            <label class="mdl-textfield__label" for="isAdmin">¿Es administrador?</label>
            <span class="mdl-textfield__error">Solo números</span> -->
            <label class="mdl-textfield__label">¿Es administrador?</label>
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

<?php
include './footer.php';
?>