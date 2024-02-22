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
    $(document).on("click", "#modal-client-add .js-client-add", function (e) {
        let create_url = API_V1_URLS.clients.create; // API_V1_URLS - Смотрим в main.js
        let formData = get_formdata_by_components("#modal-client-add");

        // Если есть заполненные поля
        if (formData) {
            $.ajax({
                url: create_url,
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == "succsess") {
                        push("Вы успешно добавили нового клиента", "succsess", 30000);
                    }
                },
            });
        }
    });
});
// End Добаввление клиента в базу данных
