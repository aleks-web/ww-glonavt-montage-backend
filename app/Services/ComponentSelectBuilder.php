<?php

namespace WWCrm\Services;

use WWCrm\ServiceContainer;

final class ComponentSelectBuilder {
    protected string $db_field_name;
    protected string $title = '';
    protected bool $required;
    protected string|array|int|null $val = '';
    protected array $items = [];
    protected array $boofer_item = []; // Текущий item
    protected string $default_text = '';
    protected string $position = 'bottom';
    protected $WWCrmService;

    public function __construct(string $db_field_name, bool $required = false, array $array_settings = null) {
        $this->WWCrmService = ServiceContainer::getInstance();
        $this->db_field_name = $db_field_name;
        $this->required = $required;

        // $array_settings - массив настроек
    }


    /*
        Установить name
    */
    public function setInputName(string $name) {
        $this->title = $name;
    }

    /*
        Вернуть name
    */
    public function getInputName() : string {
        return $this->name;
    }


    /*
        Установить title
    */
    public function setTitle(string $title) {
        $this->title = $title;
    }

    /*
        Вернуть title
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
    public function setVal(int | string | array | null $val) : void {
        if ($val) {
            $this->val = $val;
        }
    }

    /*
        Возвращает установленное значение value
    */
    public function getVal() : string | array | int {
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

    /*
        Возвращает отрендеренный элемент
    */
    public function toHtml() : string {
        $settings = $this->toArray(); // Получаем массив настроек

        return $html = $this->WWCrmService->get('View')->render('components/select.twig', $settings);
    }

}