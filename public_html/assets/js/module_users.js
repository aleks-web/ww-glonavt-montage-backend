$(document).ready(function (e) {

    $(document).on('click', '[data-modal-user]', function (e) {
        let client_id = $(this).data('user-id');

        if (client_id) {
            
            add_body_bg();
            $('#modal-user').addClass('open');
            
        } else {
            alert('Не задан id сотрудника в атрибуте data-user-id');
        }
    });

    $(document).on('click', '[data-modal-user-add]', function (e) {
            add_body_bg();
            $('#modal-user-add').addClass('open');
    });

});


// Start функция, которая получает html разметку главной таблицы и вставляет ее | Модуль сотрудники
function xrender_main_table_users() {
    // Разбиваем строку wrapper_and_element на обертку и twig элемент
    let wrapper = $("#region-main-table");
    let twig_element = "main-table.twig";

    twig_url = twig_element.indexOf(".");
    twig_url = twig_element.substring(0, twig_url);

    let url = API_V1_URLS.users.render + twig_url;

    $.ajax({
        url: url,
        method: "POST",
        data: {
            twig_element: twig_element,
            control_panel_condition: $('.control .input-search input').val(),
        },
        success: function (response) {
            wrapper.removeClass("loading");

            if (response.status == "success") {
                wrapper.html(response.render_response_html);

                dd_render_success(
                    response,
                    'modules/users/render/' + twig_element,
                    url
                );
            }

            if (response.status == "error") {
                wrapper.html(`<div style="height: 100%; width: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">${response.message}</div>`);
            }
        },
        beforeSend: function () {
            wrapper.addClass("loading");
        },
    });
}
// End функция, которая получает html разметку главной таблицы и вставляет ее | Модуль сотрудники

/*
    Загрузка модального окна "Добавление нового сотрудника"
*/
xpost_fd(API_V1_URLS.users.render + 'modal-user-add').then(response => {
    $('#modal-user-add-wrapper').html(response.render_response_html);

    dd_render_success(response, 'modal-user-add.twig', API_V1_URLS.users.render + 'modal-user-add');
});