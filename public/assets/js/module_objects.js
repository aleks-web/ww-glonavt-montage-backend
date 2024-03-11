$(document).ready(function (e) {

    $(document).on('click', '[data-modal-object]', function (e) {
        let object_id = $(this).data('object-id');

        if (object_id) {
            load_modal_object(object_id);
        } else {
            alert('Не задан id объекта в атрибуте data-object-id');
        }
    });

    // Start функция рендера и открытия модалки "Добавление объекта"
    $(document).on('click', '[data-modal-object-add]', function (e) {
        $.ajax({
            url: API_V1_URLS.objects.render + 'modal-object-add',
            method: "POST",
            data: {
                twig_element: 'modal-object-add.twig',
            },
            success: function (response) {

                if (response.status == "success") {
                    add_body_bg();

                    $('#region-modal-object-add').html(response.render_response_html);

                    setTimeout(() => { // Без таймаута анимация открытия модалки страдает
                        cpns_init(); // Обновляем инициализацию компонентов
                        $("#modal-object-add").addClass("open");
                    }, 10);

                    dd(response, `Render modal-object-add.twig ${API_V1_URLS.clients.render + 'modal-object-add'}`);
                }
            }
        });
    });
    // End функция рендера и открытия модалки "Добавление объекта"

});




// Start Функция загрузки модального окна объекты | Модуль объекты
function load_modal_object(object_id) {
    $.ajax({
        url: API_V1_URLS.objects.render + 'modal-object',
        method: "POST",
        data: {
            twig_element: 'modal-object.twig',
            object_id: object_id
        },
        success: function (response) {

            if (response.status == "success") {
                add_body_bg();

                $('#region-modal-object').html(response.render_response_html);

                setTimeout(() => { // Без таймаута анимация открытия модалки страдает
                    $("#modal-object").addClass("open");
                }, 10);
            }

            if (response.status == "error") {
                wrapper.html(`<div style="height: 100%; width: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">${response.message}</div>`);
            }

            dd(response, `Render modal-object.twig ${API_V1_URLS.clients.render + 'modal-object'}`);
        }
    });
}
// End Функция загрузки модального окна объекты | Модуль объекты



// Start пагинация и фильтр поиска
$(document).ready(() => {
    // Start реализация пагинации для главной таблицы клиентов
    $(document).on("click", ".module-objects .main-table-pagination button", function () {
        let control_condition = false;

        xrender_main_table_objects($(this).data("page"));
    });
    // End реализация пагинации для главной таблицы клиентов


    // Start фильтр поиска
    $('.module-clients .input-search input').on('input', function (e) {
        let val = $(this).val();

        xrender_main_table_clients(1, { name: val, inn: val });
    });
    // End фильтр поиска
});
// End пагинация и фильтр поиска


// Start функция, которая получает html разметку главной таблицы и вставляет ее | Модуль объекты
function xrender_main_table_objects(current_page = 1, control_panel_condition = null) {
    // Разбиваем строку wrapper_and_element на обертку и twig элемент
    let wrapper = $("#region-main-table");
    let twig_element = "main-table.twig";

    twig_url = twig_element.indexOf(".");
    twig_url = twig_element.substring(0, twig_url);

    let url = API_V1_URLS.objects.render + twig_url;

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

            dd(response, `Render main-table.twig ${url}`);
        },
        beforeSend: function () {
            wrapper.addClass("loading");
        },
    });
}
// Start функция, которая получает html разметку главной таблицы и вставляет ее | Модуль объекты





