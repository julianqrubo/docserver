<?php
    session_start();
    if (!isset($_SESSION["__user__"])) {
        header('Location: index.php');
        exit;
    }
    include './header.php';
    include './db.php';
    $stmt = $db->prepare("SELECT ID, documentId, name, address, phone FROM company");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row_cunter = $stmt->rowCount();
?>
<h3 style="text-align: center;">Empresas</h3>

<div style="width: 600px; margin: auto;">
    <div style="text-align: right; padding-bottom: 20px;">
        <button id="create-companies-button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
            Crear
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
                <th class="mdl-data-table__cell--non-numeric">Direcci&oacute;n</th>
                <th>Tel&eacute;fono</th>
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
                    <td><?php echo $row["phone"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="padding: 10px; text-align: center; color: #444;"><?php echo $row_cunter; ?> registros encontrados</div>
</div>

<dialog id="delete-companies-dialog" class="mdl-dialog" action="delete_companies.php">
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