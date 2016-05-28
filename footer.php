<?php 
    //Para ponerlo en producción debe poner $mode = ".min";
    $mode = "";
?>
<dialog class="mdl-dialog" id="change-pwd-dialog" style="width: 500px">
    <div class="mdl-dialog__content">
        <div style="text-align: center;">
            <h3>Cambiar contraseña</h3>
            <form action="changepwd.php" id="changepwd-form">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password" id="current_password" name="current_password">
                    <label class="mdl-textfield__label" for="current_password"><b>Contraseña actual*</b></label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password" id="password" name="password">
                    <label class="mdl-textfield__label" for="password"><b>Contraseña nueva*</b></label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password" id="repassword" name="repassword">
                    <label class="mdl-textfield__label" for="repassword"><b>Confirmar contraseña*</b></label>
                </div>
            </form>
        </div>
    </div>
    <div class="mdl-dialog__actions">
        <button id="close-button" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Cancelar</button>
        <button id="change-pwd-button" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Aceptar</button>
    </div>
</dialog>
</div>
</main>

<footer class="mdl-mini-footer" style="">
    <div class="mdl-mini-footer__left-section">
        <ul class="mdl-mini-footer__link-list">
            <li><a href="#">Ayuda</a></li>
            <li><a href="#">Terminos</a></li>
            <li><a href="#">Acerca de</a></li>
        </ul>
    </div>
</footer>

<div id="status-snackbar" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>

</div>
<script src="js/material<?php echo $mode; ?>.js"></script>
<script src="js/jquery-2.2.4<?php echo $mode; ?>.js"></script>
<script src="js/logic.js"></script>
</body>
</html>