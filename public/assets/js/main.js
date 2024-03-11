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



// Start функция дебага
function dd(message = "dd - не задано сообщение для отображения в консоли", title = false) {
    if (WWCrmConfig.debug) {
        if (title) {
            console.log(`%c${title}`, "color: green; font-size: 14px; font-weight: bold");
        }

        console.log(message);

        console.log(`%c------`, "color: green;");
    }
}
// End функция дебага



// Start табы в модалках
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

    $(document).on("click", ".modal .modal__header-btn-edit, .modal .modal__header-btn-save", function (e) {
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

            // Смена кнопок
            btn_edit.fadeOut(200, () => {
                btn_save.fadeIn(200);
            });
        }

        // Если клик по кнопке "Сохранить"
        if ($(this).hasClass(save_class)) {
            $modal.find(".tabs__item--active .view").css("display", "flex");
            $modal.find(".tabs__item--active .edit").css("display", "none");

            // Смена кнопок
            btn_save.fadeOut(200, () => {
                btn_edit.fadeIn(200);
            });
        }
    });
});
// End табы в модалках

// Start функция ресайза таблицы в модалке
/*
    Пусути костыль, т.к версткой выкрутиться не получилось. Нужно просто тянуть таблицу, если она одна на все занимаемое пространство
    Скрипт отрабатывает в модалках с классом .modal в табах.
*/
function resizeTableModal() {
    $(".modal.open").each(function (index, element) {
        if ($(this).find(".tabs__item--active .tabs__tableContainer").length > 0) {
            $(this).find(".tabs__item--active .tabs__tableContainer").removeAttr("style");

            let headerHeight = $(this).find(".modal__header").outerHeight(); // Высота шапки модалки
            let tabsHeight = $(this).find(".tabs__header").outerHeight(); // Высота шапки табов
            let tabsControl = $(this).find(".tabs__item--active .tabs__control").outerHeight(); // Высота контрольной панели
            let tableTitle = $(this).find(".tabs__item--active .tabs__tableTitle").outerHeight(); // Высота контрольной панели

            let css = `calc(100dvh - calc(${tabsHeight}px + ${headerHeight}px + calc(var(--bigModal-padding-y) * 2) + var(--modal-gap-main) + var(--tab-gap-main)))`;
            if (tabsControl) {
                css = `calc(100dvh - calc(${tabsControl}px + ${tabsHeight}px + ${headerHeight}px + calc(var(--bigModal-padding-y) * 2) + var(--modal-gap-main) + calc(var(--tab-gap-main) * 2)))`;
            }

            $(this).find(".tabs__item--active .tabs__tableContainer").css("height", css);
            $(this).find(".tabs__item--active .tabs__table").css("height", `calc(100% - ${tableTitle}px)`);
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

        if ($('body').find('.modal.open').length <= 0) {
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
function xpost_fd(url, formData) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == "success") {
                    push(response.message ? response.message : "Успешный запрос", "success", 2000);
                    resolve(response);
                } else {
                    reject(response);
                    console.log(response);
                }
            },
        });
    });
}
// End отправка запроса на сервер

// Start какие-то настрйоки
const WWCrmConfig = {
    debug: true,
};
// End какие-то настрйоки

// Start Глобально доступная константа. Содержит ссылки API
const API_V1_URLS = {
    clients: {
        create: "/api_v1/clients/create/",
        update: "/api_v1/clients/update/",
        create_contact_person: "/api_v1/clients/contacts-persons/create/",
        update_contact_person: "/api_v1/clients/contacts-persons/update/",
        remove_contact_person: "/api_v1/clients/contacts-persons/remove/",
        render: "/api_v1/clients/render/",
    },
    objects: {
        render: "/api_v1/objects/render/",
    },
    book_equipments: {
        update: "/api_v1/book-equipment/update/",
        render: "/api_v1/book-equipment/render/"
    }
};
// End Глобально доступная константа. Содержит ссылки API
