$(function () {
    var setup_data_table = function (concept, on_ok, on_okCreate) {
        var table = document.querySelector("#" + concept + "-data-table");
        if (table) {
            setup_delete_dialog(concept, on_ok);
            if (concept == "companies") {
                setup_change_dialog(concept, on_ok);
            }
            var headerCheckbox = table.querySelector('thead .mdl-data-table__select input');
            var boxes = table.querySelectorAll('tbody .mdl-data-table__select');
            setup_create_dialog(concept, on_okCreate);
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
                checkedIds.push(boxes[i].id.replace(concept + "_row_", ""));
            }
        }
        return checkedIds;
    };

    var setup_create_dialog = function (concept, on_ok) {
        var createButton = document.querySelector("#" + "create-" + concept + "-button");
        var dialogCreate = document.querySelector("#" + "create-" + concept + "-dialog");
        if (dialogCreate) {
            if (!dialogCreate.showModal) {
                dialogPolyfill.registerDialog(dialogCreate);
            }
            var closeCreateButton = dialogCreate.querySelector('.closeCreate-button');
            var okCreateButton = dialogCreate.querySelector('.okCreate-button');
            createButton.addEventListener('click', function () {
                dialogCreate.showModal();
            });
            closeCreateButton.addEventListener('click', function () {
                dialogCreate.close();
            });
            okCreateButton.addEventListener('click', function () {
                on_ok(dialogCreate.querySelector('form'), dialogCreate.getAttribute("action"));
            });
        }
    };

    var setup_delete_dialog = function (concept, on_ok) {
        var deleteButton = document.querySelector("#" + "delete-" + concept + "-button");
        var dialog = document.querySelector("#" + "delete-" + concept + "-dialog");
        if (!dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        var closeButton = dialog.querySelector('.close-button');
        var okButton = dialog.querySelector('.ok-button');
        deleteButton.addEventListener('click', function () {
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
    var setup_change_dialog = function (concept, on_ok) {
        var changeStatusButton = document.querySelector("#" + "changeStatus-" + concept + "-button");
        var dialogChangeStatus = document.querySelector("#" + "changeStatus-" + concept + "-dialog");
        if (!dialogChangeStatus.showModal) {
            dialogPolyfill.registerDialog(dialogChangeStatus);
        }
        var closeButtonChangeStatus = dialogChangeStatus.querySelector('.closeChangeStatus-button');
        var okButtonChangeStatus = dialogChangeStatus.querySelector('.okChangeStatus-button');
        changeStatusButton.addEventListener('click', function () {
            if (get_selected_rows(concept).length > 0) {
                dialogChangeStatus.querySelector(".mdl-progress").style.display = "none";
                dialogChangeStatus.showModal();
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
        closeButtonChangeStatus.addEventListener('click', function () {
            dialogChangeStatus.close();
        });
        okButtonChangeStatus.addEventListener('click', function () {
            dialogChangeStatus.querySelector(".mdl-progress").style.display = "";
            on_ok(get_selected_rows(concept), dialogChangeStatus.getAttribute("action"));
        });
    };

    //onload
    $('#sigin').on("click", function (e) {
        var $frm = $("#sigin-form");
        $.post($frm.attr("action"), $frm.serialize(), function (response) {
            location.href = location.href.replace("index.php", "") + "ftpFiles.php";
        }).fail(function (error) {
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
    if (dialog) {
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
    }

    // Validar el tipo de concepto
    var conceptType = "";
    var createCompanyDialog = document.querySelector('#create-companies-dialog');
    var deleteCompanyDialog = document.querySelector('#delete-companies-dialog');
    var changeStatusCompanyDialog = document.querySelector('#changeStatus-companies-dialog');
    var createUserDialog = document.querySelector('#create-users-dialog');
    var deleteUserDialog = document.querySelector('#delete-users-dialog');
    var createClassifierDialog = document.querySelector('#create-classifier-dialog');
    var deleteClassifierDialog = document.querySelector('#delete-classifier-dialog');
    var createFileDialog = document.querySelector('#create-file-dialog');
    var deleteFileDialog = document.querySelector('#delete-file-dialog');

    if (createCompanyDialog || deleteCompanyDialog || changeStatusCompanyDialog) {
        conceptType = "companies";
    }
    if (createUserDialog || deleteUserDialog) {
        conceptType = "users";
    }
    if (createClassifierDialog || deleteClassifierDialog) {
        conceptType = "classifier";
    }
    if (createFileDialog || deleteFileDialog) {
        conceptType = "file";
    }
    setup_data_table(conceptType, function (sels, action) {
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
    }, function (form, action) {
        $.post(action, $(form).serialize(), function (response) {
            location.reload();
        }).fail(function (error) {
            var snackbarContainer = document.querySelector('#status-snackbar');
            var data = {
                message: error.responseText || error.statusText,
                timeout: 2000,
                actionText: 'Ok'
            };
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        });
    });

    var setupAutoComplete = function (id, url, qs) {
        var $hidden = $(id);
        var $text = $(id + '_raw');
        var $autocomplete_div = $('<div class="autocomplete-options mdl-shadow--2dp"></div>');
        $autocomplete_div.insertAfter($text.parent());
        $text.on('keyup', function (e) {
            if (e.target.value.length > 0) {
                var fullqs = {q: e.target.value};
                if (qs) {
                    for (var k in qs) {
                        if (qs[k].indexOf("#") === 0) {
                            fullqs[k] = $(qs[k]).val();
                        } else {
                            fullqs[k] = qs[k];
                        }
                    }
                }
                $.get(url, fullqs, function (res) {
                    var result = $.parseJSON(res);
                    $autocomplete_div.empty();

                    var $autocomplete_options = $('<ul></ul>');
                    $autocomplete_options.appendTo($autocomplete_div);
                    for (var i = 0; i < result.length; i++) {
                        var $autocomplete_option = $('<li id="' + result[i].id + '">' + result[i].name + '</li>');
                        $autocomplete_option.on('click', function (e) {
                            $hidden.val(e.target.getAttribute('id'));
                            $text.val(e.target.innerText);
                            $autocomplete_div.hide();
                        });
                        $autocomplete_option.appendTo($autocomplete_options);
                    }
                    $autocomplete_div.show();
                });
            } else {
                $autocomplete_div.empty();
            }
        });
    };

    setupAutoComplete("#companyId", "/docserver/companiesAutoComplete.php");
    setupAutoComplete("#classifierId", "/docserver/classifierAutoComplete.php", {companyId: "#companyId"});

    $('#filter_classiferId').on('change', function (e) {
        var $lis = $(e.target).parent().parent().next().children();
        for (var i = 0; i < $lis.length; i++) {
            var $li = $($lis[i]);
            if (e.target.value) {
                if (e.target.value === $li.attr('classifier')) {
                    $li.show();
                } else {
                    $li.hide();
                }
            } else {
                if ($li.attr('classifier')) {
                    $li.hide();
                } else {
                    $li.show();
                }
            }
        }
    });

    $('#uploadFile').on('click', function (e) {
        document.querySelector(".mdl-progress").style.display = '';
    });
});
