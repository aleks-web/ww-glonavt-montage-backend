// Start функция подгрузки главной таблицы
function xrender_main_table_book_objects() {
    // Разбиваем строку wrapper_and_element на обертку и twig элемент
    let wrapper = $("#region-main-table");
    let url = API_V1_URLS.book_objects.render + 'main-table';

    $.ajax({
        url: url,
        method: "POST",
        data: {
            twig_element: 'main-table.twig',
            control_panel_condition: $('.module-book-objects .input-search input').val(),
        },
        success: function (response) {
            wrapper.removeClass("loading");

            if (response.status == "success") {
                wrapper.html(response.render_response_html);

                dd_render_success(response, 'main-table.twig', url);
            }
        },
        beforeSend: function () {
            wrapper.addClass("loading");
        },
    });
}
// End функция подгрузки главной таблицы

// Start Функция подгрузки модального окна "Добавление нового типа объекта"
function load_fmodal_new_type_object() {
    let url = API_V1_URLS.book_objects.render + 'fmodal-book-new-type-object';

    xpost_fd(url).then(response => {
        $('#fmodal-book-new-type-object-wrapper').html(response.render_response_html);

        dd_render_success(response, 'fmodal-book-new-type-object.twig', url);
    }).catch(response => {
        dd(response, 'Не удалось отрендерить fmodal-book-new-type-object.twig', 'error');
    });
}
load_fmodal_new_type_object();
// End Функция подгрузки модального окна "Добавление нового типа объекта"


// Start Функция удаления типа объекта
function delete_book_object_type(book_object_id) {
    let url = API_V1_URLS.book_objects.delete;
    let formData = new FormData();
    formData.append('id', book_object_id);

    xpost_fd(url, formData).then(response => {
        xrender_main_table_book_objects();
        dd(response, response.message, 'success');
        push(response.message, 'success');
    }).catch(response => {
        dd(response, response.message, 'error');
        push(response.message, 'error');
    });
}
// End Функция удаления типа объекта

// Start Функция редактирования типа объекта
function load_fmodal_type_object_edit(book_object_id) {
    let url = API_V1_URLS.book_objects.render + 'fmodal-book-type-object-update';
    let formData = new FormData();
    formData.append('id', book_object_id);

    xpost_fd(url, formData).then(response => {
        $('#fmodal-book-type-object-update-wrapper').html(response.render_response_html);

        $.fancybox.open({
            src: '#fmodal-book-type-object-update',
            type: 'inline'
        });

        dd_render_success(response, 'fmodal-book-type-object-update.twig', url);
    }).catch(response => {
        dd(response, 'Не удалось отрендерить fmodal-book-type-object-update.twig', 'error');
    });
}
// End Функция редактирования типа объекта