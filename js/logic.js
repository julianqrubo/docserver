$(function () {
    var setup_data_table = function (concept, on_ok) {
        var table = document.querySelector("#" + concept + "-data-table");
        if(table){
            setup_dialog(concept, on_ok);
            var headerCheckbox = table.querySelector('thead .mdl-data-table__select input');
            var boxes = table.querySelectorAll('tbody .mdl-data-table__select');
            var headerCheckHandler = function (event) {
                if (event.target.checked) {
                    for (var i = 0, length = boxes.length; i < length; i++) {
                        boxes[i].MaterialCheckbox.check();
                    }
                } else {
                    for (var i = 0, length = boxes.length; i < length; i++) {
                        boxes[i].MaterialCheckbox.uncheck();
                    }
                }
            };
            headerCheckbox.addEventListener('change', headerCheckHandler);
        }
    };
    var get_selected_rows = function (concept) {
        var table = document.querySelector("#" + concept + "-data-table");
        var boxes = table.querySelectorAll('tbody .mdl-checkbox__input');
        var checkedIds = [];
        for (var i = 0, length = boxes.length; i < length; i++) {
            if (boxes[i].checked) {
                checkedIds.push(boxes[i].id.replace("#" + concept + "_row_", ""));
            }
        }
        return checkedIds;
    };
    var setup_dialog = function (concept, on_ok) {
        var showButton = document.querySelector("#" + "delete-" + concept + "-button");
        var dialog = document.querySelector("#" + "delete-" + concept + "-dialog");
        var closeButton = dialog.querySelector('.close-button');
        var okButton = dialog.querySelector('.ok-button');
        showButton.addEventListener('click', function () {
            if (get_selected_rows(concept).length > 0) {
                dialog.querySelector(".mdl-progress").style.display = "none";
                dialog.showModal();
            } else {
                var snackbarContainer = document.querySelector('#status-snackbar');
                var data = {
                    message: "Debe seleccionar al menos un registro",
                    timeout: 4000,
                    actionText: 'Ok'
                };
                snackbarContainer.MaterialSnackbar.showSnackbar(data);
            }
        });
        closeButton.addEventListener('click', function () {
            dialog.close();
        });
        okButton.addEventListener('click', function () {
            dialog.querySelector(".mdl-progress").style.display = "";
            on_ok(get_selected_rows(concept), dialog.getAttribute("action"));
        });
    };
    //onload
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
    //Change password dialog
    var dialog = document.querySelector('#change-pwd-dialog');
    var closeButton = dialog.querySelector('#close-button');
    var changePwdButton = dialog.querySelector('#change-pwd-button');
    var showButton = document.querySelector('#change-pwd');
    if (!dialog.showModal) {
        dialogPolyfill.registerDialog(dialog);
    }
    showButton.addEventListener('click', function (event) {
        dialog.showModal();
    });
    closeButton.addEventListener('click', function (event) {
        dialog.close();
    });
    changePwdButton.addEventListener('click', function (event) {
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
    });
    setup_data_table("companies", function (sels, action) {
        $.post(action, {ids: sels.join(',')}, function () {
            location.reload();
        }).fail(function (error) {
            var snackbarContainer = document.querySelector('#status-snackbar');
            var data = {
                message: error.responseText,
                timeout: 4000,
                actionText: 'Ok'
            };
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        });
    });
    
    $('#create-users-button').on("click", function (e) {
        location.href = location.href.replace("users.php", "formCreateUser.php")
    });
    
    $('#create-companies-button').on("click", function (e) {
        location.href = location.href.replace("companies.php", "formCreateCompany.php")
    });
    
    $('#insert-comapny-button').on("click", function (e) {
        var $frm = $("#createCompany-form");
        $.post($frm.attr("action"), $frm.serialize(), function (response) {
            console.log(arguments);
            location.href = location.href.replace("formCreateCompany.php", "createCompany.php")
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
    
    $('#insert-user-button').on("click", function (e) {
        var $frm = $("#createUser-form");
        $.post($frm.attr("action"), $frm.serialize(), function (response) {
            console.log(arguments);
            location.href = location.href.replace("formCreateUser.php", "createUser.php")
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