<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
$company = $_SESSION['__company__'];
//$stmt = $db->prepare("SELECT path FROM company WHERE id = ?");
$stmt = $db->prepare("SELECT c.path pathc, u.ID, u.classifierId, u.companyId, u.path pathu, u.size, u.source_name, u.state, u.type, u.upload_date, u.user 
                    FROM company c, upload_file u 
                    WHERE c.ID = u.companyId
                    AND c.id = ?");
$stmt->execute(array($company));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$files = [];
$path = "";
$uploadId = NULL;

// Alimentar el combo con los clasificadores creados para la empresa
$stmt_cbox = $db->prepare("SELECT ID, name FROM classifier where companyId = ? and state = 1 order by name asc");
$stmt_cbox->execute(array($company));
$rows_cbox = $stmt_cbox->fetchAll(PDO::FETCH_ASSOC);
$row_cunter_cbox = $stmt_cbox->rowCount();
$cboxClassifier = "";
foreach ($rows_cbox as $id) {
    $cboxClassifier .=" <option value='" . $id['ID'] . "'>" . $id['name'] . "</option>";
}
?>
<h3 style="text-align: center;">Archivos disponibles</h3>

<div style="text-align: center">    
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 200px;">
        <label class="mdl-textfield__label"><b>Clasificador</b></label>
        <select id="filter_classiferId" name="filter_classiferId" class="mdl-textfield__input">
            <option value=""></option>
            <?php echo $cboxClassifier; ?>
        </select>
    </div>
</div>
<ul class="files mdl-list">
    <?php
    foreach ($rows as $row) {
            $path = $row["pathu"];
        ?>
        <li class = "mdl-list__item" classifier="<?php echo $row["classifierId"]?>">
            <span class = "mdl-list__item-primary-content">
                <i class = "material-icons">attach_file</i>
                <a href = "downloadFile.php?path=<?php echo $path?>&filename=<?php echo $row['source_name']; ?>&fileid=<?php echo $row['ID']; ?>" id = "download_text"><?php echo $row['source_name']; ?></a>
            </span>
            <a href="downloadFile.php?path=<?php echo $path . "/" . $row['ID']; ?>&filename=<?php echo $row['source_name']; ?>&fileid=<?php echo $row['ID']; ?>" id="download_icon"><i class="material-icons">cloud_download</i></a>
        </li>
        <?php
    }
    ?>
</ul>
<?php
include './footer.php';
?>