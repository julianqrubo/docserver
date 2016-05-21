<?php include './header.php'; ?>
        <div class="demo-card-wide mdl-card mdl-shadow--2dp" style="margin-left: auto; margin-right: auto; margin-top: 20%;">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">Inicio de sesi&oacute;n</h2>
            </div>

            <div style="text-align: center;">
                <form action="login.php" id="sigin-form">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="username" name="username" pattern="[A-Za-z\.@]+">
                        <label class="mdl-textfield__label" for="username">Nombre de usuario</label>
                        <span class="mdl-textfield__error">Solo se permiten letras, puntos (.) o el signo de arroba (@)</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="password" id="password" name="password">
                        <label class="mdl-textfield__label" for="password">Contrase&ntilde;a</label>
                    </div>
                </form>
                <div class="mdl-card__actions mdl-card--border">
                    <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" id="sigin">
                        Iniciar sesi&oacute;n
                    </a>
                </div>
            </div>
        </div>
<?php include './footer.php'; ?>