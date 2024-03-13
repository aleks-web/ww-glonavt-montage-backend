// Start функционал добавления строк в таблицу у модалки "Новый тип оборудования"
$(document).ready(function() {
    cpns_form_validate('#fmodal-book-new-type-equipment', '.js-submitter', true); // Сразу валидируем модалку

    let $modal = $('#fmodal-book-new-type-equipment');
    let $table = $modal.find('.fmodal__add-table');
    let count_rows = $table.data('count');

    function add_line() {
        const lineTpl = `
            <div class="fmodal__add-table-line" data-id="${count_rows + 1}" style="display: none;">
                <div class="fmodal__add-table-rowNum">${count_rows + 1}</div>

                <div class="fmodal__add-table-field">
                    <div class="component-wrapper">
                        <div data-name="name_${count_rows + 1}" class="input-text required">
                            <input type="text" name="name_${count_rows + 1}" value="" placeholder="Название параметра *">
                        </div>
                        <div class="input-messages input-messages--bottom disable">
                            <span class="input-messages__icon"></span>
                            <span class="input-messages__text"></span>
                        </div>
                    </div>
                </div>
                
                <div class="fmodal__add-table-field">
                    <div class="component-wrapper">
                        <div class="select required  select--top">
                            <input class="select__input" name="type_${count_rows + 1}" type="hidden" value="input-text">
                            <div class="select__current"><span class="select__current-text">Текстовое поле</span></div>
                            <div class="select__list">
                                <div data-id="input-text" data-text="Текстовое поле" class="select__item select__item--active">Текстовое поле</div>
                                <div data-id="input-date" data-text="Поле с датой" class="select__item ">Поле с датой</div>
                            </div>
                        </div>
                        <div class="input-messages input-messages--bottom disable ">
                            <span class="input-messages__icon"></span>
                            <span class="input-messages__text"></span>
                        </div>
                    </div>
                </div>
                <div class="fmodal__add-table-del"><svg><use xlink:href="#svg-del"></use></svg></div>
            </div>
        `;

        $table.append(lineTpl); // Вставляем в конце
        cpns_form_validate('#fmodal-book-new-type-equipment', '.js-submitter', true); // Запускаем валидацию
        $table.find('.fmodal__add-table-line[data-id="' + (count_rows + 1) + '"]').slideDown(100, () => { // Показываем
            count_rows = count_rows + 1;
            $table.data('count', count_rows);
        });
    }

    function del_line() {
        let lineID = $(this).parents('.fmodal__add-table-line').data('id');

        console.log(lineID);

        if (count_rows > 1) {
            let line = $modal.find('.fmodal__add-table-line[data-id="' + lineID + '"]');
            line.remove();
            count_rows = count_rows - 1; // Уменьшаем
            $table.data('count', count_rows); // Устанавливаем текущее количество строк
            update_table(); // Обнавляем
        } else {
            push("Нельзя удалить единственную строку", "error", 1000);
        }
    }

    function update_table() {
        let lines = $modal.find('.fmodal__add-table-line');

        lines.each(function(i, el) { // Перестраиваем инпуты
            index = i + 1;
            el.setAttribute('data-id', index);

            $(el).find('.fmodal__add-table-rowNum').text(index);

            let inputText = $(el).find('.input-text');

            inputText.data('name', 'name_' + index);
            inputText.find('input').attr('name', 'name_' + index);

            $(el).find('.select .select__input').attr('name', 'type_' + index);
        });

        cpns_form_validate('#fmodal-book-new-type-equipment', '.js-submitter', true); // Запускаем валидацию
    }

    $(document).on('click', '#fmodal-book-new-type-equipment .fmodal__add-table-btn', add_line);
    $(document).on('click', '#fmodal-book-new-type-equipment .fmodal__add-table-del', del_line);

    $(document).on('click', '#fmodal-book-new-type-equipment .js-submitter', () => { // Добавление оборудования в бд
        let $modal = $('#fmodal-book-new-type-equipment');
        let formData = new FormData();


        formData.append('name', $modal.find('input[name="name_equipment"]').val()); // Вносим название оборудования
        $modal.find('.fmodal__add-table .fmodal__add-table-line').each(function(i, el) {
            let inputVal = $(this).find('.input-text input').val();
            let inputName = $(this).find('.input-text input').attr('name');

            let selectVal = $(this).find('.select input').val();
            let selectName = $(this).find('.select input').attr('name');

            formData.append(inputName, inputVal);
            formData.append(selectName, selectVal);
        });

        xpost_fd(API_V1_URLS.book_equipments.create, formData).then(response => {
            $.fancybox.close();
            dd(response, 'Создан новый тип оборудования');
            cpns_clear_by_wrapper('#fmodal-book-new-type-equipment'); // Очищаем компоненты
            cpns_form_validate('#fmodal-book-new-type-equipment', '.js-submitter', true); // Валидируем
            xrender_main_table_book_equipments(1); // Функция в twig находится. Обновление главной таблицы
        });

    });

});
// End функционал добавления строк в таблицу у модалки "Новый тип оборудования"


