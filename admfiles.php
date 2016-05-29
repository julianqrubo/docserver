<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';
$company = $_SESSION['__company__'];
$stmt = $db->prepare("SELECT path FROM company WHERE id = ?");
$stmt->execute(array($company));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$files = [];
$path = "";
if ($row) {
    $path = getcwd() . '/fileRepository/';
    if (file_exists($path)) {
        $files = array_diff(scandir($path), array('..', '.'));
        if (count($files)) {
            ?>
            <h3 style="text-align: center;">Archivos disponibles</h3>

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
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        } else {
            ?>
            <h3 style="text-align: center;">No hay archivos disponibles</h3>
            <?php
        }
    } else {
        ?>
        <h3 style="text-align: center;">No hay archivos disponibles</h3>
        <?php
    }
} else {
    ?>
    <h3 style="text-align: center;">No hay archivos disponibles</h3>
    <?php
}
include './footer.php';
?>