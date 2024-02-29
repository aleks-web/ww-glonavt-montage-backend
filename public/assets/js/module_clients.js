// Start Модаки
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
// End Модаки

// Start функция, которая получает html разметку главной таблицы и вставляет ее
function xrender_main_table_clients(current_page = 1, control_panel_condition = null) {
    // Разбиваем строку wrapper_and_element на обертку и twig элемент
    let wrapper = $("#region-main-table");
    let twig_element = "main-table.twig";

    twig_url = twig_element.indexOf(".");
    twig_url = twig_element.substring(0, twig_url);

    let url = API_V1_URLS.clients.render + twig_url;

    $.ajax({
        url: url,
        method: "POST",
        data: {
            twig_element: twig_element,
            current_page: current_page, // Текущая страница, если есть
            control_panel_condition: control_panel_condition,
        },
        success: function (response) {
            wrapper.removeClass("loading");

            if (response.status == "success") {
                wrapper.html(response.render_response_html);
            }

            if (response.status == "error") {
                wrapper.html(`<div style="height: 100%; width: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">${response.message}</div>`);
            }

            console.log(response);
        },
        beforeSend: function () {
            wrapper.addClass("loading");
        },
    });
}
// Start функция, которая получает html разметку главной таблицы и вставляет ее

// Start реализация пагинации для главной таблицы клиентов
$(document).on("click", ".module-clients .main-table-pagination button", function () {
    xrender_main_table_clients($(this).data("page"));
});
// End реализация пагинации для главной таблицы клиентов

// Start Добаввление клиента в базу данных | Модалка добавления нового пользователя
$(document).ready(function (e) {
    $(document).on("click", "#modal-client-add .js-submitter", function (e) {
        let create_url = API_V1_URLS.clients.create; // API_V1_URLS - Смотрим в main.js
        let formData = cpns_get_formdata_by_wrapper("#modal-client-add");

        // Если есть заполненные поля и нет ошибок, отправляем запрос
        if (formData && !cpns_get_errors_by_wrapper("#modal-client-add")) {
            // Отправка запроса
            xpost_fd(create_url, formData).then(function (data) {
                cpns_clear_by_wrapper("#modal-client-add");
                xrender_main_table_clients("region-main-table:main-table.twig"); // Обновляем главную таблицу клиентов
                $("#modal-client-add [data-modal-close]").trigger("click");
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

        cpns_update_from_json(data, "#modal-client-add");
    });
});
// End Добаввление клиента в базу данных | Модалка добавления нового пользователя

// Start фильтр поиска
$(document).on("input", ".module-clients .input-search input", function (e) {
    let val = $(this).val();

    let current_page = $(".main-table-pagination").data("current-page");

    xrender_main_table_clients(current_page + 1, { name_or_inn: val });
});
// End фильтр поиска
