<?php
session_start();
if (!isset($_SESSION["__user__"])) {
    header('Location: index.php');
    exit;
}
include './header.php';
include './db.php';

$path = "";
$company = $_SESSION['__company__'];
$stmt = $db->prepare("SELECT path FROM company WHERE id = ?");
$stmt->execute(array($company));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    $path_company = $row["path"];
}
$path_base = 'ftpRepository/';
$path_app = '/docserver';
$path = filter_input(INPUT_GET, "path");
?>

<h3 style="text-align: center;">Explorador de archivos</h3>
<div class="mdl-textfield mdl-js-textfield" style="margin-left: 40%; margin-right: auto;">
    <input class="mdl-textfield__input" type="text" id="file_filter">
    <label class="mdl-textfield__label" for="file_filter">Filtrar...</label>
</div>
<div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-left: auto; margin-right: auto; margin-top: 1%; margin-bottom: 5%; width: 700px;">
    <span class = "mdl-list__item-primary-content" style="margin-left: 5%; margin-right: 5%; margin-top: 1%; margin-bottom: 5%; text-align: center;">
        <?php
        if (!empty($path)) {
            $parts = explode("/", $path);
            if (count($parts) > 1) {
                $parent_path = str_replace("/" . end(explode("/", $path)), "", $path);
                echo '<li class="mdl-list__item" style="text-align: left;"><a href="?path=' . $parent_path . '" style="height: 30px; line-height: 30px; display: block; width: 100%;"><i class="material-icons" style="vertical-align: middle; display: inline-block;">folder_open</i><span class="mdl-list__item-primary-content" style="vertical-align: middle; display: inline-block;">..</span></a></li>';
            } else {
                echo '<li class="mdl-list__item" style="text-align: left;"><a href="?path=" style="height: 30px; line-height: 30px; display: block; width: 100%;"><i class="material-icons" style="vertical-align: middle; display: inline-block;">folder_open</i><span class="mdl-list__item-primary-content" style="vertical-align: middle; display: inline-block;">..</span></a></li>';
            }
        }
        ?>
        <ul class="demo-list-item mdl-list" id="files-list" style="width: 600px">

        </ul>
        <div id="loading-more-files" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="display: none;"></div>
        <!--        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" id="load-more-files" style="display: none;">
                    Cargar m&aacute;s
                </button>-->
    </span>
</div>


<script type="text/javascript">
    var path = "<?php echo $path; ?>";
</script>


    <script type="text/javascript">
        var path = "<?php echo $path; ?>";
    </script>

    <?php
    include './footer.php';
    ?>
