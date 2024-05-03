// Start Функции для создания и удаления заднего фона
/*
    Создано для использования модалками.
    Может пригодиться в каких-нибудь других случаях.
    Функции вызываются в других скриптах.
*/
function add_body_bg() {
    $("body").addClass("bg");
}

function remove_body_bg() {
    $("body").removeClass("bg");
}
// End Функции для создания и удаления заднего фона

/*
    Инициализация уведомлений
*/
const notyf = new Notyf();


/*
    Start функции дебага
    Desc: Различне функции для дебага
*/
function dd(object = "Объект не передан функции dd в main.js!", title = false, type = 'success') {
    let color = 'green';
    if (type == 'error') {
        color = 'red';
    }

    if (WWCrmConfig.debug) {
        if (title) {
            console.log(`%c${title}`, `color: ${color}; font-size: 14px; font-weight: bold`);
        }

        console.log(object);

        console.log(`%c------`, `color: ${color};`);
    }
}

function dd_render_success(response, twig_element, url_request) {
    if (WWCrmConfig.debug) {
        console.log(`%c----------- RENDER START -----------`, "color: green;");

        if (twig_element) {
            console.log(`%cTWIG ELEMENT:`, "color: green; font-size: 14px; font-weight: bold");
            console.log(`${twig_element}`);
        }
        if (url_request) {
            console.log(`%cURL REQUEST:`, "color: green; font-size: 14px; font-weight: bold");
            console.log(`${url_request}`);
        }

        console.log(`%cRESPONSE:`, "color: green; font-size: 14px; font-weight: bold");
        console.log(response);
        console.log(`%c----------- RENDER END -----------\n\n\n\n`, "color: green;");
    }
};
// End функции дебага

/*
    Start табы в модалках
*/
$(document).ready(function (e) {
    $(document).on("click", ".tabs__tab", function (e) {
        const tab_class = "tabs__tab";
        const tab_class_active = "tabs__tab--active";
        const tab_content_class = "tabs__item";
        const tab_content_class_active = "tabs__item--active";
        const tab_outside_class = "tab-outside";
        const tab_outside_class_active = "tab-outside--active";

        let tab_id = Number($(this).data("id"));
        let parent = $(this).parents(".tabs"); // Обертка классов

        let outside_names = parent.data("outside").split("|"); // Получаем массив через разделитель

        if (tab_id) {
            let all_tabs = parent.find("." + tab_class);
            let all_tabs_content = parent.find("." + tab_content_class);

            all_tabs.removeClass(tab_class_active); // Удаляем у всех табов активный класс
            all_tabs_content.removeClass(tab_content_class_active); // Удаляем у всего содержимого активный класс

            $(this).addClass(tab_class_active); // Делаем текущий таб, по которому кликнули активным
            parent.find("." + tab_content_class + '[data-id="' + tab_id + '"]').addClass(tab_content_class_active); // Находим контент активного таба и показываем его

            outside_names.forEach((element) => {
                // Меняем содержимое, которое находится вне табов
                let outside_class_name = "tabs-outside-" + element; // Устанавливаем класс

                $("." + outside_class_name).each(function (i, el) {
                    // Ищем класс
                    let all_outside_tabs = $(el).find("." + tab_outside_class); // Все табы
                    all_outside_tabs.removeClass(tab_outside_class_active); // Удаляем у всех активный класс

                    let now_outside_tab = $(el).find("." + tab_outside_class + '[data-outside-id="' + tab_id + '"]');
                    now_outside_tab.addClass(tab_outside_class_active); // Отображаем таб
                });
            });

            let event = new Event("tabsClick", { bubbles: true });
            document.dispatchEvent(event); // Активируем событие tabsClick
        } else {
            alert("Атрибут data-id пустой. Необходимо поставить id вкладки");
        }
    });
});
// End табы в модалках


/*
    Данная функция универсальна для любого модального окна класса .modal.
    Выполняет сохранение данных на сервер
    Первый панаметр - это id модального окна
    Второй параметр - функция коллбек, которая собственно сохраняет данные на сервер.
    Функция должна возвращать true либо false в зависимости от результат сохранения!
    Только так функционал переключения с режима редактирования в режим просмотра и наборот будет работать корректно!

    Мотив создания функции - уменьшить однотипный код переключения вкладок. Он универсален всегда!
*/
function save_big_modal(modal_id, save_function_collback, tab_id = null) {

    if (!tab_id) {
        alert('Вы не задали tab_id в функции save_big_modal');
        return false;
    }

    cpns_form_validate(`#modal-current-user .tabs__item[data-id="${tab_id}"] .modal__data-edit`, `.tab-outside[data-outside-id="${tab_id}"] .modal__header-btn-save`);

    let elements = `#${modal_id} .tab-outside[data-outside-id="${tab_id}"] .modal__header-btn-edit, #${modal_id} .tab-outside[data-outside-id="${tab_id}"] .modal__header-btn-save`;

    $(elements).click(function (e) {
        let edit_class = "modal__header-btn-edit";
        let save_class = "modal__header-btn-save";

        let $parent_outside = $(this).parents(".tab-outside"); // outside

        let btn_edit = $parent_outside.find(`.${edit_class}`); // Edit btn
        let btn_save = $parent_outside.find(`.${save_class}`); // Save btn

        let $modal = $(this).parents(".modal");

        // Если клик по кнопке "Редактировать"
        if ($(this).hasClass(edit_class)) {
            $modal.find(".tabs__item--active .view").css("display", "none");
            $modal.find(".tabs__item--active .edit").css("display", "flex");

            btn_edit.css('display', 'none');
            btn_save.css('display', 'block');
        }

        // Если клик по кнопке "Сохранить"
        if ($(this).hasClass(save_class)) {
            save_function_collback().then(response => {
                $(elements).off();
                
                setTimeout(() => {
                    $modal.find(".tabs__item--active .view").css("display", "flex");
                    $modal.find(".tabs__item--active .edit").css("display", "none");

                    btn_edit.css('display', 'block');
                    btn_save.css('display', 'none');
                }, 500);
            }).catch(response => {
                
            });
        }
    });
}




/*
    Start функция ресайза таблицы в модалке
    
    По своей сути костыль, т.к версткой выкрутиться не получилось. Менеджер хотел правки как по дизайну.
    Нужно просто тянуть таблицу по высоте, если она одна на все занимаемое пространство
    Скрипт отрабатывает в модалках с классом .modal в табах.
*/
function resizeTableModal() {
    $(".modal.open").each(function (index, element) {
        if ($(this).find(".tabs__item--active .tabs__tableContainer").length > 0) {
            $(this).find(".tabs__item--active .tabs__tableContainer").removeAttr("style");

            let headerHeight = $(this).find(".modal__header").outerHeight(); // Высота шапки модалки
            let tabsHeight = $(this).find(".tabs__header").outerHeight(); // Высота шапки табов
            let tabsControl = $(this).find(".tabs__item--active .tabs__control").outerHeight(); // Высота контрольной панели
            let tableTitle = $(this).find(".tabs__item--active .tabs__tableTitle").outerHeight(); // Высота тайтла

            let css = `calc(100dvh - calc(${tabsHeight}px + ${headerHeight}px + calc(var(--bigModal-padding-y) * 2) + var(--modal-gap-main) + var(--tab-gap-main)))`;
            if (tabsControl) {
                // Если есть контрольная панель
                css = `calc(100dvh - calc(${tabsControl}px + ${tabsHeight}px + ${headerHeight}px + calc(var(--bigModal-padding-y) * 2) + var(--modal-gap-main) + calc(var(--tab-gap-main) * 2)))`;
            }

            $(this).find(".tabs__item--active .tabs__tableContainer").css("height", css);
            $(this).find(".tabs__item--active .tabs__table").css("height", `calc(100% - ${tableTitle}px)`);

            // Если это таб "Оборудование в модуле объекты"
            // if ($(this).find(".tabs__item--active").attr("id") == "modal-object-tab-equipment-content") {
            //     $(this).find(".tabs__item--active .tabs__table").css("height", "auto");
            // }
        }

        if ($(this).find(".tabs__item--active > *").not(".tabs__control").length == 1) {
            $(this).find(".tabs__item--active > *").not(".tabs__control").css("padding", "0");
        }
    });
}
// End функция ресайза таблицы в модалке

// Start различные скрипты по работе с модалками
$(document).ready(function (e) {
    // Start закрытие модального окна
    /*
        Это универсальный скрипт. Убирает затемнение фона. Функцией remove_body_bg;
        Убирает класс open у класса модалки.
        Атрибут data-modal-close можно ставить на любой элемент. Главное, чтобы элемент был дочерним по отношению к классу modal
    */
    $(document).on("click", "[data-modal-close]", function (e) {
        $(this).parents(".modal").removeClass("open");

        if ($("body").find(".modal.open").length <= 0) { // Если больше нет открытых модалок
            remove_body_bg();
        }
    });
    // End закрытие модального окна

    $(window).on("resize", function (e) {
        resizeTableModal(); // При событии ресайза запускаем функцию-костыль для изменения высоты таблиц в открытых модалках
    });

    $(document).on("tabsClick", function (e) {
        resizeTableModal(); // tabsClick - это кастомное событие, которое срабатывает в момент клика по табу
    });
});
// End различные скрипты по работе с модалками

// Start скрипт для меню
$(document).ready(function (e) {
    $(document).on("click", ".menu__item-link", function (e) {
        let parent = $(this).parents(".menu__item");
        let list = $(this).next(".menu__item-list");

        if (list.length > 0) {
            e.preventDefault();

            if (parent.hasClass("menu__item--active")) {
                list.slideUp(200);
                parent.removeClass("menu__item--active");
            } else {
                list.slideDown(200);
                parent.addClass("menu__item--active");
            }
        }
    });
});
// End скрипт для меню


/*
    Start отправка запроса на сервер

    Расшифровка xpost_fd:
        x - ajax,
        post - метод POST,
        fd - formData объект с содержимым формы
*/
function xpost_fd(url, formData = null) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == "success") {
                    resolve(response);
                } else {
                    reject(response);
                }
            },
        });
    });
}
// End отправка запроса на сервер