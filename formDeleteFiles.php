<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
$stmt = $db->prepare("SELECT uf.ID, u.username, c.name companyName, cl.name classifier, uf.size, uf.upload_date
                        FROM upload_file uf
                        inner join company c on (uf.companyId = c.ID)
                        inner join users u on (uf.companyId = u.companyId)
                        inner join classifier cl on (uf.companyId = cl.companyId and uf.classifierId = cl.ID)
                        where cl.state = 1 and uf.state = 1 order by cl.name asc, uf.upload_date");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();
?>

<h3 style="text-align: center;">Eliminación de archivos</h3>

<div style="width: 95%; margin: auto;">
    <div style="text-align: right; padding-bottom: 20px;">
        <button id="delete-file-button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
            Eliminar
        </button>
    </div>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 100%;" id="file-data-table">
        <thead>
            <tr>
                <th>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="file-table-header">
                        <input type="checkbox" id="file-table-header" class="mdl-checkbox__input" />
                    </label>
                </th>
                <th>Usuario</th>
                <th class="mdl-data-table__cell--non-numeric">Empresa</th>
                <th class="mdl-data-table__cell--non-numeric">Clasificador</th>
                <th class="mdl-data-table__cell--non-numeric">Tamaño</th>
                <th class="mdl-data-table__cell--non-numeric">Fecha de cargue</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $row) {
                ?>
                <tr>
                    <td>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="file_row_<?php echo $row['ID']; ?>">
                            <input type="checkbox" id="file_row_<?php echo $row['ID']; ?>" class="mdl-checkbox__input" />
                        </label>
                    </td>
                    <td><?php echo $row["username"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["companyName"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["classifier"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["size"]/1024 . " MB"; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["upload_date"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="padding: 10px; text-align: center; color: #444;"><?php echo $row_cunter; ?> registros encontrados</div>
</div>

<dialog id="delete-file-dialog" class="mdl-dialog" action="delete_files.php" style="width: 500px;">
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