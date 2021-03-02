$(function() {
    var addForm, editForm, removeForm, form;

    // обработчик выбора типа актива из списка в форме добавления
    $("#add-asset-form select[name='type_asset']").change(function() {
        $.ajax({
            url: "ajax.php",
            data: {
                type_asset: $("#add-asset-form [name='type_asset']").val()
            },
            context: $("#add-asset-form .custom-fields"),
            success: function(data) {
                $(this).empty();
                $(this).append(data);
            }
        });
    });

    // Создаём форму добавления
    addForm = $("#add-asset-form").dialog({
        autoOpen: false,
        width: 450,
        modal: true,
        buttons: {
            "Добавить": function() {
                $("#add-asset-form form").submit();
            },
            Отмена: function() {
                addForm.dialog("close");
            }
        },
        open: function() {
            $("#add-asset-form select[name='type_asset']").change();
        },
        close: function() {}
    });

    // Создаём форму редактирования
    editForm = $("#edit-asset-form").dialog({
        autoOpen: false,
        width: 450,
        modal: true,
        buttons: {
            "Обновить": function() {
                $("#edit-asset-form form").submit();
            },
            Отмена: function() {
                editForm.dialog("close");
            }
        },
        open: function() {
            $.ajax({
                url: "ajax.php",
                data: {
                    type_asset: $("#edit-asset-form [name='type_asset']").val(),
                    id: $("#edit-asset-form").data("id")
                },
                context: $("#edit-asset-form .custom-fields"),
                success: function(data) {
                    $(this).empty();
                    $(this).append(data);
                }
            });
        },
        close: function() {}
    });

    // Создаём форму удаления
    removeForm = $("#remove-asset-form").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 450,
        buttons: {
            "Удалить": function() {
                $("#remove-asset-form form").submit();
            },
            Отмена: function() {
                removeForm.dialog("close");
            }
        },
        open: function() {
            $("#remove-asset-form input[name='id']").val($("#remove-asset-form").data("id"));
            $("#remove-asset-form input[name='type_asset']").val($("#remove-asset-form").data("type_asset"));
            $("#remove-asset-form input[name='id_asset']").val($("#remove-asset-form").data("id_asset"));
            $("#remove-asset-form p").append($("#remove-asset-form").data("name") + '" ?');
        },
        close: function() {}
    });

    // при нажатии на "Добавить актив", загружаем соотв. форму
    $("#add-asset").button().on("click", function() {
        addForm.dialog("open");
    });


    $(document).ready(function() {
        // Создаём DataTable
        var table = $('#table_id').DataTable({
            paging: false,
            info: false,
            searching: false,
            "columnDefs": [{
                "targets": [0],
                "visible": false,
                "searchable": false
            }, {
                "targets": [1],
                "visible": true,
                "searchable": true,
                "title": "Название актива"
            }, {
                "targets": [2],
                "visible": false,
                "searchable": false
            }, {
                "targets": [3],
                "visible": false,
                "searchable": false
            }, {
                "targets": [4],
                "visible": true,
                "searchable": false,
                "title": "Тип актива"
            }, {
                "targets": [5],
                "visible": true,
                "searchable": false,
                "title": "Номинал"
            }, {
                "targets": [6],
                "visible": true,
                "searchable": false,
                "title": "Курс",
                "orderable": false
            }, {
                "targets": [7],
                "visible": true,
                "searchable": false,
                "orderable": false
            }, {
                "targets": [8],
                "visible": true,
                "searchable": false,
                "orderable": false
            }]
        });

        // навешиваем обработчик события на кнопку "Правка"
        $("#table_id tbody").on("click", ".asset-edit", function() {
            var tr = $(this).closest('tr');
            var data = table.row(tr).data(); // получаем данные строки, в которой была нажата кнопка
            $("#edit-asset-form").data("id", data[0]);
            $("#edit-asset-form input[name='name']").val(data[1]); // инициализируем значение поля в форме редактирования
            $("#edit-asset-form input[name='type_asset']").val(data[2]);
            $("#edit-asset-form input[name='asset_name']").val(data[4]);
            editForm.dialog("open"); // открываем форму редактирования
        });

        // навешиваем обработчик события на кнопку "удалить"
        $("#table_id tbody").on("click", ".asset-remove", function() {
            var tr = $(this).closest('tr');
            var data = table.row(tr).data(); // получаем данные строки, в которой была нажата кнопка
            $("#remove-asset-form").data("id", data[0]); // сохраним нужные значения в HTML5 -data для дальнейшей отправки в сценарий
            $("#remove-asset-form").data("name", data[1]);
            $("#remove-asset-form").data("type_asset", data[2]);
            $("#remove-asset-form").data("id_asset", data[3]);
            removeForm.dialog("open"); // открываем форму удаления
        });
    });
});