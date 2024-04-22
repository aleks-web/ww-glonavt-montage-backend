<?php

namespace WWCrm\Services;

/*

    * settings - массив с настройками
        * title - заголовок (не обязательно)
        * db_field_name - Имя поля (если компонент записывает данные в БД, то db_field_name равно названию поля из базы данных)
        * val - значение инпута в атрибуте value. Может быть единым значением, может имень вид в виде массива : [1, 2, 3]
        * not_selected_text - пункт меню "Не выбрано". Если не проброшен, то не выводится, если задан, то выводится с заданным текстом
        * required - обязательный ли инпут
        * input_messages_position - расположение сообщений об ошибках и прочее. Либо bottom (по умолчанию, но можно изменить здесь) либо top
        * checkbox - если true, то добавляет класс select__item--checkbox для item элементов и можно выбирать сразу несколько элементов
        * position - позиция выпадающего меню

*/
final class ComponentSelectBuilder {
    protected string $db_field_name;
    protected string $title = '';
    protected bool $required;
    protected string|array $val = '';
    protected array $items = [];
    protected array $boofer_item = []; // Текущий item
    protected string $default_text = '';
    protected string $position = 'bottom';

    public function __construct($db_field_name, $required = false) {
        $this->db_field_name = $db_field_name;
        $this->required = $required;
    }

    /*
        Установить title
    */
    public function setTitle(string $title) {
        $this->title = $title;
    }

    /*
        Установить title
    */
    public function getTitle() : string {
        return $this->title;
    }

    /*
        Получает название списка списка
    */
    public function getDbFieldName() : string {
        return $this->db_field_name;
    }

    /*
        Устанавливает значение value в инпут
    */
    public function setVal(string | array $val) : void {
        $this->val = $val;
    }

    /*
        Возвращает установленное значение value
    */
    public function getVal() : string | array {
        return $this->val;
    }

    /*
        Добавляем id элементу из выпадающего списка
    */
    public function addIdItem($id) : ComponentSelectBuilder {
        $this->boofer_item['id'] = $id;
        return $this;
    }

    /*
        Добавляем отображаемый текст элементу из выпадающего списка
    */
    public function addTextItem($text) : ComponentSelectBuilder {
        $this->boofer_item['text'] = $text;
        return $this;
    }

    /*
        Добавляем отображаемый текст элементу из выпадающего списка
    */
    public function addCurrentTextItem($current_text) : ComponentSelectBuilder {
        $this->boofer_item['current_text'] = $current_text;
        return $this;
    }

    public function saveItem() : ComponentSelectBuilder | bool {
        if (!empty($this->boofer_item)) {

            if (empty($this->boofer_item['current_text'])) {
                $this->boofer_item['current_text'] = $this->boofer_item['text'];
            }

            $this->items[$this->boofer_item['id']] = $this->boofer_item;
            $this->boofer_item = []; // Очищаем текущий буфер массив с настройками элемента и можно заново собирать методами

            return $this;
        } else {
            return false;
        }
    }

    public function getItems() : array { // Получает список элементов
        return $this->items;
    }

    /*
        Метод устанавливает логическое значение
        Обязателен ли для заполнения данный селект
    */
    public function setRequired($bool = false) : void {
        $this->required = $bool;
    }

    /*
        Метод возвращает логическое значение
        Обязателен ли для заполнения данный селект
    */
    public function getRequired() : bool {
        return $this->required;
    }

    /*
        Метод устанавливает значение дефолтного текста
    */
    public function setDefaultText(string $text) : void {
        $this->default_text = $text;
    }

    /*
        Метод возвращает значение дефолтного текста
    */
    public function getDefaultText() : string {
        return $this->default_text;
    }


    /*
        Метод устанавливает отображение выпадающего списка. Верху или снизу
    */
    public function setPosition($position_text) : void {
        $this->position = $position_text;
    }

    /*
        Метод возвращает отображение выпадающего списка
    */
    public function getPosition() : string {
        return $this->position;
    }

    /*
        Метод возвращает настроенный массив для компонента .select
    */
    public function toArray() {
        $settings['required'] = $this->getRequired();
        $settings['db_field_name'] = $this->getDbFieldName();
        $settings['val'] = $this->getVal();
        $settings['title'] = $this->getTitle();
        $settings['not_selected_text'] = $this->getDefaultText() ?: null; // Устанавливаем дефолтное значение
        $settings['position'] = $this->getPosition();

        $select_array['settings'] = $settings;
        $select_array['items'] = $this->getItems();

        return $select_array;
    }

}