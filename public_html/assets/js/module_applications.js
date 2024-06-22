$(document).ready(function (e) {

    $(document).on('click', '[data-modal-application]', function (e) {
        let application_id = $(this).data('application-id');

        if (application_id && e.target.tagName != 'svg' && e.target.tagName != 'use' && !$(e.target).hasClass('td-btn-favorite')) {
            add_body_bg();
            $('#modal-application').addClass('open');
        }
    });

    $(document).on('click', '[data-modal-application-add]', function (e) {
        add_body_bg();
        $('#modal-application-add').addClass('open');
    });

});

// Start функция, которая получает html разметку главной таблицы и вставляет ее | Модуль объекты
function xrender_main_table_apl(current_page = 1, control_panel_condition = null) {

    // Разбиваем строку wrapper_and_element на обертку и twig элемент
    let wrapper = $("#region-main-table");

    let url = API_V1_ROUTS.Applications.render + 'main-table';

    $.ajax({
        url: url,
        method: "POST",
        data: {
            current_page: current_page, // Текущая страница, если есть
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
                'modules/applications/render/main-table',
                url
            );
        },
        beforeSend: function () {
            wrapper.addClass("loading");
        },
    });
}
// Start функция, которая получает html разметку главной таблицы и вставляет ее | Модуль объекты