$(document).ready(function (e) {
    $(document).on("click", "[data-modal-client]", function (e) {
        let client_id = $(this).data("client-id");

        if (client_id) {
            add_body_bg();
            $("#modal-client").addClass("open");
        } else {
            alert("Не задан id клиента в атрибуте data-client-id");
        }
    });

    $(document).on("click", "[data-modal-client-add]", function (e) {
        add_body_bg();
        $("#modal-client-add").addClass("open");
    });
});

// Start Добаввление клиента в базу данных
$(document).ready(function (e) {
    $(document).on("click", "#modal-client-add .js-submitter", function (e) {
        let create_url = API_V1_URLS.clients.create; // API_V1_URLS - Смотрим в main.js
        let formData = cpns_get_formdata_by_wrapper("#modal-client-add");

        // Если есть заполненные поля и нет ошибок, отправляем запрос
        if (formData && !cpns_get_errors_by_wrapper("#modal-client-add")) {
            // Отправка запроса
            xpost_fd(create_url, formData).then(function(data) {
                cpns_clear_by_wrapper('#modal-client-add');
            });
        }

    });

    $(document).bind("keyup change", cpns_get_classes_by_wrapper("#modal-client-add"), function (e) {
        let data = cpns_get_errors_by_wrapper("#modal-client-add"); // Массив с полями, которые не прошли проверку

        if (data) {
            $("#modal-client-add .js-submitter").addClass("disable");
        } else {
            $("#modal-client-add .js-submitter").removeClass("disable");
        }

        cpns_update_from_json(data, '#modal-client-add');
    });
});
// End Добаввление клиента в базу данных
