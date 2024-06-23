$(document).ready(function (e) {

    $(document).on('click', '[data-modal-application]', function (e) {
        let application_id = $(this).data('application-id');

        if (application_id && e.target.tagName != 'svg' && e.target.tagName != 'use' && !$(e.target).hasClass('td-btn-favorite')) {
            load_modal_application(application_id).then(r => {
                add_body_bg();
                $('#modal-application').addClass('open');
            });
        }
    });

    $(document).on('click', '[data-modal-application-add]', function (e) {
        add_body_bg();
        $('#modal-application-add').addClass('open');
    });

});




// Start функция вставляет разметку модального окна клиента | Модуль клиенты
function load_modal_application(application_id, is_open = false) {
    return new Promise(function(resolve, reject) {
        let url = API_V1_ROUTS.Applications.render + 'modal-application';
    
        $.ajax({
            url: url,
            method: "POST",
            data: {
                twig_element: 'modal-application.twig',
                application_id: application_id,
                is_open: is_open
            },
            success: function (response) {
    
                if (response.status == "success") {
                    $('#modal-application-wrapper').html(response.render_response_html);
                    
                    dd_render_success(
                        response,
                        'modules/applications/render/modal-application.twig',
                        url
                    );

                    resolve(response);
                }
    
                if (response.status == "error") {
                    dd(response, `Render modal-application.twig ${API_V1_URLS.clients.render + 'modal-application'}`);
                    reject(response);
                }
    
            }
        });
    });
}
// End функция вставляет разметку модального окна клиента | Модуль клиенты




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


// Start Функция рендерит и вставляет модалкку добавления заявки
function load_modal_application_add() {
    let url = API_V1_ROUTS.Applications.render + 'modal-application-add';
    
    xpost_fd(url).then(response => {
        $('#modal-application-add-wrapper').html(response.render_response_html);

        cpns_form_validate('#modal-application-add', '.submitter', true);

        dd_render_success(
            response,
            'modules/clients/render/modal-application-add.twig',
            url
        );
    }).catch(response => {
        dd(response, response.message ? response.message : 'Не удалось отрендерить modal-application-add.twig', 'error');
    });
}
$(document).ready(function (e) {
    load_modal_application_add();
});
// End Функция рендерит и вставляет модалкку добавления заявки