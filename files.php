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
                <i class="material-icons mdl-list__item-icon">person</i>
                <?php echo $file; ?>
            </span>
        </li>
        <?php
    }
    ?>
</ul>
<?php
include './footer.php';
?>