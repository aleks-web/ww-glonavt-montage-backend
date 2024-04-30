// Start функция подгрузки главной таблицы
function xrender_main_table_book_docs() {
    // Разбиваем строку wrapper_and_element на обертку и twig элемент
    let wrapper = $("#region-main-table");
    let url = API_V1_URLS.book_docs.render + 'main-table';

    $.ajax({
        url: url,
        method: "POST",
        data: {
            twig_element: 'main-table.twig',
            control_panel_condition: $('.module-book-docs .input-search input').val(),
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

// Start Функция подгрузки модального окна "Добавление нового типа документа"
function load_fmodal_new_type_doc() {
    let url = API_V1_URLS.book_docs.render + 'fmodal-book-new-type-doc';

    xpost_fd(url).then(response => {
        $('#fmodal-book-new-type-doc-wrapper').html(response.render_response_html);

        dd_render_success(response, 'fmodal-book-new-type-doc.twig', url);
    }).catch(response => {
        dd(response, 'Не удалось отрендерить fmodal-book-new-type-doc.twig', 'error');
    });
}
load_fmodal_new_type_doc();
// End Функция подгрузки модального окна "Добавление нового типа документа"


// Start Функция удаления типа документа
function delete_book_doc_type(book_doc_id) {
    let url = API_V1_URLS.book_docs.delete;
    let formData = new FormData();
    formData.append('id', book_doc_id);

    xpost_fd(url, formData).then(response => {
        xrender_main_table_book_docs();
        dd(response, response.message, 'success');
        push(response.message, 'success');
    }).catch(response => {
        dd(response, response.message, 'error');
        push(response.message, 'error');
    });
}
// End Функция удаления типа документа

// Start Функция редактирования типа документа
function load_fmodal_type_doc_edit(book_doc_id) {
    let url = API_V1_URLS.book_docs.render + 'fmodal-book-type-doc-update';
    let formData = new FormData();
    formData.append('id', book_doc_id);

    xpost_fd(url, formData).then(response => {
        $('#fmodal-book-type-doc-update-wrapper').html(response.render_response_html);

        $.fancybox.open({
            src: '#fmodal-book-type-doc-update',
            type: 'inline'
        });

        dd_render_success(response, 'fmodal-book-type-doc-update.twig', url);
    }).catch(response => {
        dd(response, 'Не удалось отрендерить fmodal-book-type-doc-update.twig', 'error');
    });
}
// End Функция редактирования типа документа