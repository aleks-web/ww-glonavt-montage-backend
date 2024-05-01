$(document).ready(function (e) {

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
$(document).ready(() => {
    xpost_fd(API_V1_URLS.users.render + 'modal-user-add').then((response) => {
        $('#modal-user-add-wrapper').html(response.render_response_html);
    
        cpns_init();
    
        dd_render_success(response, 'modal-user-add.twig', API_V1_URLS.users.render + 'modal-user-add');
    }).catch(response => {
        dd(response, 'Ошибка рендера modal-user-add.twig', 'error');
    });
});

/*
    Открытие модалки просмотра клиента 
*/
function open_modal_user(user_id) {
    load_modal_user(user_id).then(response => {
        add_body_bg();

        setTimeout(() => { // Без таймаута анимация открытия модалки страдает
            $("#modal-user").addClass("open");
        }, 10);

        dd_render_success(response, 'modal-user.twig', API_V1_URLS.users.render + 'modal-user');
    });
}

/*
    Подгрузка модалки просмотра клиента 
*/
function load_modal_user(user_id, is_open = false) {
    return new Promise(function(resolve, reject) {
        let url = API_V1_URLS.users.render + 'modal-user';

        $.ajax({
            url: url,
            method: "POST",
            data: {
                twig_element: 'modal-user.twig',
                user_id: user_id,
                is_open: is_open
            },
            success: function (response) {

                if (response.status == "success") {
                    $('#modal-user-wrapper').html(response.render_response_html);
                    resolve(response);
                }

                if (response.status == "error") {
                    reject(response);
                }
            }
        });
    });
}

/*
    Блокировка пользователя
*/
function chenge_user_status(user_id, status_id) {
    let url = API_V1_URLS.users.update;
    let formData = new FormData();
    formData.append('id', user_id);
    formData.append('status', status_id);
    formData.append('event_name', 'chenge_status');

    return xpost_fd(url, formData).then(response => {
        xrender_main_table_users();

        push(response.message, 'success');
        dd(response, response.message, 'success');

        return new Promise((resolve, reject) => {
            resolve(response);
        });
    }).catch(response => {
        push(response.message, 'error');
        dd(response, response.message, 'error');

        return new Promise((resolve, reject) => {
            reject(response);
        });
    });
}