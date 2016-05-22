<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
$dir = '/Applications/XAMPP/xamppfiles/htdocs/docserver/pdfs';
$files = array_diff(scandir($dir), array('..', '.'));
?>
<ul class="files mdl-list">
    <?php
    foreach ($files as $file) {
        ?>
        <li class="mdl-list__item">
            <span class="mdl-list__item-primary-content">
                <i class="material-icons">attach_file</i>
                <a href="#" id="download_text"><?php echo $file; ?></a>
            </span>
            <a href="#" id="download_icon"><i class="material-icons">cloud_download</i></a>
            <div class="mdl-tooltip" for="download_icon">
                Descargar el archivo
            </div>
            <div class="mdl-tooltip" for="download_text">
                Descargar el archivo
            </div>
        </li>
        <?php
    }
    ?>
</ul>
<?php
include './footer.php';
?>