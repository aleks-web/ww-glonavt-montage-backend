// Start чекбокс
$(document).ready(function (e) {
    $(".checkbox").click(function (e) {
        $(this).toggleClass("active");

        if ($(this).hasClass("active")) {
            $(this).find("input").val(1);
        } else {
            $(this).find("input").val(0);
        }
    });
});
// End чекбокс

// Start push
function push(text, type, time = 3000) {
    let push_block = $("#region-push .push");
    let push_block_text = push_block.find(".push__text");

    push_block.removeAttr("style");
    push_block.removeClass("error").removeClass("succsess");

    push_block.addClass(type);
    push_block_text.text(text);
    push_block.addClass("active");

    setTimeout(() => {
        push_block.fadeOut(400, () => {
            push_block.removeClass("active");
            push_block_text.text("");
        });
    }, time);
}
// End push

// Start input type passs
$(document).ready(function (e) {
    $(".input-block-password__icon").click(function (e) {
        let parent = $(this).parents(".input-block-password");
        let input = $(this).siblings("input");

        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
});
// End input type passs

// Start компонент добавление фото
$(document).ready(function (e) {
    $(document).on("click", ".photo-add__btn-add, .photo-add__preview", function (e) {
        if (!$(this).find("img").length) {
            $(this).parents(".photo-add").find(".photo-add__input").trigger("click");
        }
    });

    $(document).on("input", ".photo-add .photo-add__input", function (e) {
        let parent = $(this).parents(".photo-add");
        let view = parent.find(".photo-add__preview");
        let file = this.files[0];

        const reader = new FileReader();
        reader.addEventListener("load", function () {
            let tpl = `<div data-fancybox data-src="${this.result}"><img src="${this.result}"></div>`;

            view.html(tpl);
        });
        reader.readAsDataURL(file);
    });
});
// End компонент добавление фото

// Start input files add block
$(document).ready(function (e) {
    $(document).on("click", ".files-add__btn", function (e) {
        let parent = $(this).parents(".files-add");
        let input = parent.find(".files-add__input");

        input.trigger("click");
    });

    $(document).on("input", ".files-add .files-add__input", function (e) {
        let parent = $(this).parents(".files-add");
        let view = parent.find(".files-add__view");
        let info = parent.find(".files-add__info");
        let files = this.files;

        info.css("display", "none");
        view.html("");

        for (let i = 0; i < files.length; i++) {
            let file = files.item(i);

            const reader = new FileReader();
            reader.addEventListener("load", function () {
                let tpl = `<span data-url="${this.result}">${file.name}</span>`;
                view.append(tpl);
            });
            reader.readAsDataURL(file);
        }
    });
});
// End input files add block

// Start input-text
$(document).ready(function (e) {
    $(document).on("click", ".input-text", function (e) {
        $(this).find("input").focus();
    });
});
// End input-text

// Start select block input
$(document).ready(function (e) {
    const select_class = "select";
    const select_class_active = "select--active";
    const select_input = "select__input";
    const select_current = "select__current";
    const select_current_text = "select__current-text";
    const item_class = "select__item";
    const item_class_active = "select__item--active";
    const item_default_class = "select__item--default";
    const item_checkbox_class = "select__item--checkbox";
    const body_list = "select__list";

    $(document).on("click", "." + select_class, function (e) {
        $(".select").not($(this)).removeClass(select_class_active);

        if ($(e.target).hasClass("select") || $(e.target).hasClass("select__current-text") || $(e.target).hasClass("select__name") || $(e.target).hasClass("select__current")) {
            $(this).toggleClass(select_class_active);
        }
    });

    $(document).on("click", "." + select_class + " ." + item_class, function (e) {
        let parent = $(this).parents("." + select_class);
        let input = parent.find("." + select_input);
        let input_val = [];
        let view_current_text = parent.find("." + select_current_text);
        let view_current = parent.find("." + select_current);
        let item_id = $(this).data("id");
        let item_text = [];
        let item_default = parent.find("." + item_default_class);

        $(this).siblings(".select__item--default").removeClass(item_class_active);

        const hasCheckboxItem = parent.find("." + item_checkbox_class).length;
        const hasDefaultItem = $(this).hasClass(item_default_class);

        if (hasCheckboxItem && !hasDefaultItem) {
            $(this).hasClass(item_class_active) ? $(this).removeClass(item_class_active) : $(this).addClass(item_class_active);

            parent.find("." + item_class_active).each(function (index, el) {
                item_text.push($(el).data("text"));
                input_val.push($(el).data("id"));
            });

            input.val(JSON.stringify(input_val)); // Записываем выбранные данные в input в формате JSON

            if (!item_text.length) {
                item_text.push(view_current_text.data("default-text"));
                view_current.addClass("disable");
            } else {
                view_current.removeClass("disable");
            }

            view_current_text.text(item_text.join(", "));
        } else if (!hasCheckboxItem && !hasDefaultItem) {
            input.val(item_id);
            $(this)
                .siblings("." + item_class)
                .removeClass(item_class_active);
            $(this).addClass(item_class_active);
            view_current.removeClass("disable");
            view_current_text.text($(this).data("text"));
            parent.removeClass(select_class_active);
        }

        if (hasDefaultItem) {
            clear();
        }

        function clear() {
            let default_current_text = "Не выбрано";
            if (view_current_text.data("default-text")) {
                default_current_text = view_current_text.data("default-text");
            }

            input.val("");
            parent.find("." + item_class).removeClass(item_class_active);
            view_current_text.text(default_current_text);
            view_current.addClass("disable");
            item_default.addClass(item_class_active);
            parent.removeClass(select_class_active);
        }
    });
});
// End select block input

// Start input file
$(document).on("change", '.input-file input[type="file"]', function (e) {
    const parent = $(this).parents(".input-file");
    const current_text = parent.find(".input-file__current");
    const remove_file_btn = parent.find(".input-file__remove-file");
    const file = this.files[0];

    let tpl = `<span class="input-file__link">${file.name}</span>`;

    current_text.removeClass("disable");
    current_text.html(tpl);

    if (this.files.length != 0) {
        remove_file_btn.removeClass("input-file__remove-file--hide");
    }

    $(document).on("click", ".input-file .input-file__remove-file", function (remove_event) {
        e.target = "";
        current_text.html("Файл");
        remove_file_btn.addClass("input-file__remove-file--hide");
        current_text.addClass("disable");
    });
});

/*
    <div class="input-file">
        <span class="input-file__current disable">Файл</span>

        <div class="input-file__group-btns">
            <div class="input-file__btn btn">
                <input type="file">
                <span class="input-file__btn-text">Выберите файл</span>
            </div>

            <button class="input-file__remove-file input-file__remove-file--hide"></button>
        </div>
    </div>
*/
// End input file

$(document).ready(function (e) {
    push("Тестовое сообщение", "error", 3000);
});

// Start обнуление
$(document).ready(function (e) {
    $(document).on("click", function (e) {
        const select_classes = {
            select: $(e.target).hasClass("select"),
            select__name: $(e.target).hasClass("select__name"),
            select__currentText: $(e.target).hasClass("select__current-text"),
            select__current: $(e.target).hasClass("select__current"),
        };

        // console.log(select_classes.select__currentText);

        // if (!select_classes.select && !select_classes.select__name && !select_classes.select__currentText && !select_classes.select__current) {
        //     $('.select').removeClass('select--active');
        // }
    });
});
// End обнуление

// Start Список компонентов с input
const input_components = ["input-text", "select", "textarea", "input-date"];
// End Список компонентов input

// Start Функция которая формирует классы для вложенного поиска. Передается обертка в которой ищутся компоненты и формируется вложенность
function cpns_get_classes_by_wrapper(wrapper_selector) {
    let find_classes = "";
    input_components.forEach(function (el) {
        find_classes = find_classes + wrapper_selector + " ." + el + ", ";
    });
    find_classes = find_classes.slice(0, -2);

    return find_classes;
}
// End Функция которая формирует классы для вложенного поиска. Передается обертка в которой ищутся компоненты и формируется вложенность

// Start Функция, которая получает объект formData учитывая все эти компоненты
function cpns_get_formdata_by_wrapper(wrapper_selector) {
    let formData = new FormData();
    let countFields = 0;

    $(cpns_get_classes_by_wrapper(wrapper_selector)).each(function (i, el) {
        let input = $(this).find("input");

        if (!input.length) {
            input = $(this).find("textarea");
        }

        if (input.val()) {
            formData.append(input.attr("name"), input.val());
            countFields = countFields + 1;
        }
    });

    if (countFields > 0) {
        return formData;
    } else {
        return false;
    }
}
// End Функция, которая получает объект formData учитывая все эти компоненты

// Start Получение ошибок в инпутах компонентов внутри какой-то обертки
function cpns_get_errors_by_wrapper(wrapper_selector) {
    let null_inputs = {};

    $(cpns_get_classes_by_wrapper(wrapper_selector)).each(function (i, el) {
        let input = $(this).find("input");

        if (!input.length) {
            input = $(this).find("textarea");
        }

        if (!input.val() && $(this).hasClass("required")) {
            null_inputs[input.attr("name")] = {
                name: input.attr("name"), // Название поля input
                message: "Поле не заполнено", // Сообщение об ошибке
                message_type: "error", // Тип сообщения
                wrapper_selector: wrapper_selector, // Родительский селектор-обертка, в котором находятся все искомые компоненты
                target: $(this), // Текущий компонент
            };
        }
    });

    if (Object.keys(null_inputs).length > 0) {
        return null_inputs;
    } else {
        return false;
    }
}
// End Получение ошибок в инпутах компонентов внутри какой-то обертки

// Start Обновление компонентов. Валидация
function cpns_update_from_json(json, wrapper_selector) {
    let components = $(cpns_get_classes_by_wrapper(wrapper_selector));

    components.removeClass("error").addClass("success");

    components.each(function () {
        let block_wrapper = $(this).parents(".component-wrapper");

        block_wrapper.find(".input-messages").removeClass("error").removeClass("success").addClass("disable");
    });

    for (let key in json) {
        // Начинаем перебирать объект и обновлять компоненты
        let name = json[key]["name"];
        let message = json[key]["message"];
        let message_type = json[key]["message_type"];
        let target = json[key]["target"];

        if (target) {
            let block_wrapper = target.parents(".component-wrapper"); // Получаем главную обертку компонента
            let input_messages = block_wrapper.find(".input-messages"); // Получаем блок с сообщениями

            input_messages.removeClass("disable").removeClass("error").removeClass("success").addClass(message_type).find(".input-messages__text").text(message);

            target.removeClass("success");
            target.addClass(message_type);
        }
    }
}
// End Обновление компонентов. Валидация

// Start Функция сброса всех данных у компонентов
function cpns_clear_by_wrapper(wrapper_selector) {
    let cpns_classes = cpns_get_classes_by_wrapper(wrapper_selector);

    $(cpns_classes).each(function () {
        let input = $(this).find("input");

        if (!input.length) {
            input = $(this).find("textarea");
        }

        input.val("");

        // Устанавливаем дефолтный текст если это селект
        if ($(this).hasClass("select")) {
            let current_text = $(this).find(".select__current-text");
            current_text.text(current_text.data("default-text"));
        }

        $(this).removeClass("success").removeClass("error");
    });
}
// End Функция сброса всех данных у компонентов

/*
    Функция, которая валидирует форму при ее изменениях
    Принимает 2 селектора. Контейнер формы и кнопку отправки
    Если в форме содератся ошибки, то кнопка отправки - не работает

    Работает с другими функциями
*/
function cpns_form_validate(form_wrapper, submitter) {
    $(cpns_get_classes_by_wrapper(form_wrapper)).on("keyup change", function (e) {
        let data = cpns_get_errors_by_wrapper(form_wrapper); // Функция получает ошибки компонентов внутри определенного контейнера

        if (data) {
            $(`${form_wrapper} ${submitter}`).addClass("disable");
        } else {
            $(`${form_wrapper} ${submitter}`).removeClass("disable");
        }

        cpns_update_from_json(data, form_wrapper); // Обновление компонентов
    });
}
// End функция, которая валидирует форму при ее изменениях


// Start функция инициализации компонентов
$(document).ready(function() {
    window.cpns_init = function () {
        // Start input-date
        $(".input-date").each(function () {
            const options = {
                dateFormat: "yyyy-MM-dd",
                timeFormat: "hh:mm",
                buttons: ["clear"],
                autoClose: true,
            };
    
            if ($(this).hasClass("air-start-today")) {
                options.minDate = new Date();
            }
            if ($(this).hasClass("air-time")) {
                options.timepicker = true;
            }
            if ($(this).hasClass("air-select-now")) {
                options.selectedDates = [new Date()];
            }
            if ($(this).hasClass("air-top")) {
                options.position = "top left";
            }
            if ($(this).hasClass("air-multi")) {
                options.multipleDates = true;
            }
            if ($(this).hasClass("air-only-years")) {
                options.view = 'years';
                options.minView = 'years';
                options.dateFormat = "yyyy";
            }
    
            new AirDatepicker($(this).find("input")[0], options);
        });
        // End input-date
    };
    cpns_init();
});
// End функция инициализации компонентов
