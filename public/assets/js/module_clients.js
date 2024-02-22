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
        let formData = get_formdata_by_components("#modal-client-add");

        // Если есть заполненные поля, отправляем запрос
        if (formData) {
            if (!get_errors_components_by_wrapper("#modal-client-add")) {
                // Если все поля введены корректно
                xpost_fd(create_url, formData);
            }
        }
    });

    $(document).bind("keyup change", get_classes_components_by_wrapper("#modal-client-add"), function (e) {
        let data; // Массив с полями, которые не прошли проверку

        if ((data = get_errors_components_by_wrapper("#modal-client-add"))) {
            $("#modal-client-add .js-submitter").addClass("disable");

            update_components_from_json(data);
        } else {
            $("#modal-client-add .js-submitter").removeClass("disable");
        }
    });
});
// End Добаввление клиента в базу данных
