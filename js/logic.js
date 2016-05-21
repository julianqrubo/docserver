$(function () {
    $('#sigin').on("click", function (e) {
        var $frm = $("#sigin-form");
        $.post($frm.attr("action"), $frm.serialize(), function (response) {
            console.log(arguments);
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
});

