<?php
    session_start();
    if (!isset($_SESSION["__user__"])) {
        header('Location: index.php');
        exit;
    }
    include './header.php';
    include './db.php';
    $stmt = $db->prepare("SELECT ID, documentId, name, address, phone, path, state FROM company order by state asc, name asc, documentId asc");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_cunter = $stmt->rowCount();
?>
<h3 style="text-align: center;">Empresas</h3>

<div style="width: 730px; margin: auto;">
    <div style="text-align: right; padding-bottom: 20px;">
        <button id="create-companies-button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
            Crear
        </button>
         <button id="changeStatus-companies-button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
            Cambiar estado
        </button>
        <button id="delete-companies-button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
            Eliminar
        </button>
    </div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 600px;" id="companies-data-table">
        <thead>
            <tr>
                <th>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="company-table-header">
                        <input type="checkbox" id="company-table-header" class="mdl-checkbox__input" />
                    </label>
                </th>
                <th>Nit</th>
                <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                <th class="mdl-data-table__cell--non-numeric">Dirección</th>
                <th class="mdl-data-table__cell--non-numeric">Teléfono</th>
                <th class="mdl-data-table__cell--non-numeric">Directorio</th>
                <th class="mdl-data-table__cell--non-numeric">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $row) {
                ?>
                <tr>
                    <td>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="companies_row_<?php echo $row['ID']; ?>">
                            <input type="checkbox" id="companies_row_<?php echo $row['ID']; ?>" class="mdl-checkbox__input" />
                        </label>
                    </td>
                    <td><?php echo $row["documentId"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["name"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["address"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["phone"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["path"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["state"] == 1 ? '<i class="material-icons">done</i>' : '<i class="material-icons">clear</i>'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="padding: 10px; text-align: center; color: #444;"><?php echo $row_cunter; ?> registros encontrados</div>
</div>

<dialog id="delete-companies-dialog" class="mdl-dialog" action="delete_companies.php" style="width: 500px;">
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

<dialog id="changeStatus-companies-dialog" class="mdl-dialog" action="changeStatus.php" style="width: 500px;">
    <h3 class="mdl-dialog__title">Cambiar Estado</h3>
    <div class="mdl-dialog__content">
        <p>
            Realmente desea cambiar el estado a los empresas seleccionadas?
        </p>
    </div>
    
    <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="display: none;"></div>

    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent closeChangeStatus-button">Cancelar</button>
        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect okChangeStatus-button">Aceptar</button>
    </div>
</dialog>

<dialog id="create-companies-dialog" class="mdl-dialog" action="createCompany.php" style="width: 500px;">
    <h3 style="text-align: center;">Registro de empresa</h3>
    <form action="createCompany.php" id="createCompany-form">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="documentId" name="documentId" pattern="^\d*$" maxlength="10">
            <label class="mdl-textfield__label" for="companyId">NIT de la empresa</label>
            <span class="mdl-textfield__error">Solo números</span>
        </div>
        <!-- <div class="mdl-tooltip" for="documentId">NIT de la empresa o documento de identificación</div> -->
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="name" name="name" pattern="[a-z\s]*$" maxlength="30">
            <label class="mdl-textfield__label" for="name">Nombre de la empresa</label>
            <span class="mdl-textfield__error">Solo letras minúsculas</span>
        </div>
        <div class="mdl-tooltip" for="name">Nombre de la empresa</div>d
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
            <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect okCreate-button">Crear</button>
            <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent closeCreate-button">Cancelar</button>
        </div>
    </form>
</dialog>

<?php
    include './footer.php';
?>