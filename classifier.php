<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
$stmt = $db->prepare("SELECT cl.ID ID, c.name companyName, cl.name classifier FROM company c, classifier cl where c.ID = cl.companyId order by c.name asc, cl.name asc");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_cunter = $stmt->rowCount();
?>

<h3 style="text-align: center;">Clasificadores</h3>

<div style="width: 900px; margin: auto;">
    <div style="text-align: right; padding-bottom: 20px;">
        <button id="create-classifier-button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
            Crear
        </button>
        <button id="delete-classifier-button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
            Eliminar
        </button>
    </div>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 900px;" id="classifier-data-table">
        <thead>
            <tr>
                <th>
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="classifier-table-header">
                        <input type="checkbox" id="classifier-table-header" class="mdl-checkbox__input" />
                    </label>
                </th>
                <th class="mdl-data-table__cell--non-numeric">Empresa</th>
                <th class="mdl-data-table__cell--non-numeric">Clasificador</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $row) {
                ?>
                <tr>
                    <td>
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="classifier_row_<?php echo $row['ID']; ?>">
                            <input type="checkbox" id="classifier_row_<?php echo $row['ID']; ?>" class="mdl-checkbox__input" />
                        </label>
                    </td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["companyName"]; ?></td>
                    <td class="mdl-data-table__cell--non-numeric"><?php echo $row["classifier"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="padding: 10px; text-align: center; color: #444;"><?php echo $row_cunter; ?> registros encontrados</div>
</div>

<dialog id="create-classifier-dialog" class="mdl-dialog" action="createClassifier.php" style="width: 500px;">
    <h3 style="text-align: center;">Crear Clasificador</h3>
    <form action="createClassifier.php" id="createClassifier-form">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="companyId_raw" name="companyId_raw">
            <input type="hidden" id="companyId" name="companyId">
            <label class="mdl-textfield__label" for="companyId">Empresa*</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" id="name" name="name" pattern="[a-zñáéíóú\s]{4,100}$" maxlength="100">
            <label class="mdl-textfield__label" for="name"><b>Nombre*</b></label>
            <span class="mdl-textfield__error">Solo letras minúsculas, espacios, entre 4 y 100 caracteres</span>
        </div>
        <div>
            <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect okCreate-button">Crear</button>
            <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent closeCreate-button">Cancelar</button>
        </div>
    </form>
</dialog>

<dialog id="delete-classifier-dialog" class="mdl-dialog" action="delete_classifier.php" style="width: 500px">
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