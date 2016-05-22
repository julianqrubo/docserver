$(function () {
    $('#sigin').on("click", function (e) {
        var $frm = $("#sigin-form");
        $.post($frm.attr("action"), $frm.serialize(), function (response) {
            console.log(arguments);
            location.href = location.href.replace("index.php", "files.php")
        }).fail(function (error) {
            console.log(error);
            var snackbarContainer = document.querySelector('#status-snackbar');
            var data = {
                message: error.responseText,
                timeout: 2000,
                actionText: 'Ok'
            };
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        });
    });

    var dialog = document.querySelector('#change-pwd-dialog');
    var closeButton = dialog.querySelector('#close-button');
    var changePwdButton = dialog.querySelector('#change-pwd-button');

    var showButton = document.querySelector('#change-pwd');
    if (!dialog.showModal) {
        dialogPolyfill.registerDialog(dialog);
    }
    var closeClickHandler = function (event) {
        dialog.close();
    };
    var showClickHandler = function (event) {
        dialog.showModal();
    };
    var changePwdClickHandler = function(event){
      var $frm = $("#changepwd-form");
        $.post($frm.attr("action"), $frm.serialize(), function () {
            $frm[0].reset();
            dialog.close();
            var snackbarContainer = document.querySelector('#status-snackbar');
            var data = {
                message: "La contaraseña se ha cambiado de forma exitosa.",
                timeout: 4000,
                actionText: 'Ok'
            };
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        }).fail(function (error) {
            var snackbarContainer = document.querySelector('#status-snackbar');
            var data = {
                message: error.responseText,
                timeout: 4000,
                actionText: 'Ok'
            };
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        });
    };
    showButton.addEventListener('click', showClickHandler);
    closeButton.addEventListener('click', closeClickHandler);
    changePwdButton.addEventListener('click', changePwdClickHandler);
});