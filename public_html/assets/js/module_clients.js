// Start Подгрузка модального окна клиента и его открытие | Модуль клиенты
$(document).ready(function (e) {
    $(document).on("click", "[data-modal-client]", function (e) {
        let client_id = $(this).data("client-id");

        if (client_id) {

            open_modal_client(client_id);

        } else {
            alert("Не задан id клиента в атрибуте data-client-id");
        }
    });
});
// End Подгрузка модального окна клиента и его открытие | Модуль клиенты



// Start Функция загрузки модального окна клиенты | Модуль клиенты
function open_modal_client(client_id) {
    
    load_modal_client(client_id).then(() => {
        add_body_bg();

        setTimeout(() => { // Без таймаута анимация открытия модалки страдает
            $("#modal-client").addClass("open");
        }, 10);
    });
}
// End Функция загрузки модального окна клиенты | Модуль клиенты



// Start функция вставляет разметку модального окна клиента | Модуль клиенты
function load_modal_client(client_id, is_open = false) {
    return new Promise(function(resolve, reject) {
        let url = API_V1_URLS.clients.render + 'modal-client';
    
        $.ajax({
            url: url,
            method: "POST",
            data: {
                twig_element: 'modal-client.twig',
                client_id: client_id,
                is_open: is_open
            },
            success: function (response) {
    
                if (response.status == "success") {
                    $('#region-modal-client').html(response.render_response_html);
                    
                    dd_render_success(
                        response,
                        'modules/clients/render/modal-client.twig',
                        url
                    );

                    resolve(response);
                }
    
                if (response.status == "error") {
                    dd(response, `Render modal-client.twig ${API_V1_URLS.clients.render + 'modal-client'}`);
                    reject(response);
                }
    
            }
        });
    });
}
// End функция вставляет разметку модального окна клиента | Модуль клиенты




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

            dd_render_success(
                response,
                'modules/clients/render/' + twig_element,
                url
            );
        },
        beforeSend: function () {
            wrapper.addClass("loading");
        },
    });
}
// End функция, которая получает html разметку главной таблицы и вставляет ее





// Start пагинация и фильтр поиска | Модуль клиенты
$(document).ready(() => {
    // Start реализация пагинации для главной таблицы клиентов
    $(document).on("click", ".module-clients .main-table-pagination button", function () {
        let control_condition = $(".control .input-search input").val();

        xrender_main_table_clients($(this).data("page"), { inn: control_condition, name: control_condition });
    });
    // End реализация пагинации для главной таблицы клиентов


    // Start фильтр поиска
    $('.module-clients .input-search input').on('input', function (e) {
        let val = $(this).val();

        xrender_main_table_clients(1, { name: val, inn: val });
    });
    // End фильтр поиска
});
// End пагинация и фильтр поиска | Модуль клиенты







// Start Добаввление клиента в базу данных | Модалка добавления нового пользователя
$(document).ready(function (e) {
    
    // Событие на открытие модалки "Добавление нового клиента"
    $(document).on("click", "[data-modal-client-add]", function (e) {
        add_body_bg();
        $("#modal-client-add").addClass("open");
    });


    // Событие на отправку данных на сервер
    $(document).on("click", "#modal-client-add .js-submitter", function (e) {
        let create_url = API_V1_URLS.clients.create; // API_V1_URLS - Смотрим в main.js
        let formData = cpns_get_formdata_by_wrapper("#modal-client-add");

        // Если есть заполненные поля и нет ошибок, отправляем запрос
        if (formData && !cpns_get_errors_by_wrapper("#modal-client-add")) {
            // Отправка запроса
            xpost_fd(create_url, formData).then(function (data) { // xpost_fd - main.js
                cpns_clear_by_wrapper("#modal-client-add");
                xrender_main_table_clients("region-main-table:main-table.twig"); // Обновляем главную таблицу клиентов
                $("#modal-client-add [data-modal-close]").trigger("click");
            });
        }
    });

    // Start валидация формы
    cpns_form_validate("#modal-client-add", ".js-submitter");
    // End валидация формы
});
// End Добаввление клиента в базу данных | Модалка добавления нового пользователя