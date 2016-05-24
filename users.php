<?php
    session_start();
    if (!isset($_SESSION["__user__"])) {
        header('Location: index.php');
        exit;
    }
    include './header.php';
    include './db.php';
    $stmt = $db->prepare("SELECT ID, companyId, name, lastName, userName, pwd, email, phone, isAdmin FROM users");
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
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row["companyId"]; ?></td>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row["name"]; ?></td>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row["lastName"]; ?></td>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row["userName"]; ?></td>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row["email"]; ?></td>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row["phone"]; ?></td>
                        <td class="mdl-data-table__cell--non-numeric"><?php echo $row["isAdmin"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
    </table>
    <div style="padding: 10px; text-align: center; color: #444;"><?php echo $row_cunter; ?> registros encontrados</div>
</div>

<dialog id="delete-users-dialog" class="mdl-dialog" action="delete_users.php">
    <h3 class="mdl-dialog__title">Eliminar</h3>
    <div class="mdl-dialog__content">
        <p>
            Realmente desea eliminar los registros seleccionados?
        </p>
    </div>
    
    <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="display: none;"></div>

    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button ok-button" >Eliminar</button>
        <button type="button" class="mdl-button close-button">Cancelar</button>
    </div>
</dialog>

<?php
    include './footer.php';
?>