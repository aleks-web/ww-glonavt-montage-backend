<?php

namespace WWCrm\Services;

use WWCrm\ServiceContainer;

final class ComponentSelectBuilder {
    protected $WWCrmService;
    protected array $settings = [];
    protected array $boofer_item = []; // Текущий item. Очищается после сохранения в $items
    protected array $items = []; // Все items

    /*
        Начальная конфигурация билдера
    */
    public function __construct(array $array_settings = null) {
        $this->WWCrmService = ServiceContainer::getInstance();
        
        /*
            Если проброшен массив с настройками, то конфигурируем массив
        */
        $this->fromArraySettings($array_settings);
    }

    /*
        Метод устанавливающий настройки из массива
    */
    public function fromArraySettings(array $array_settings = null) {
        if ($array_settings) {
            foreach ($array_settings as $key => $val) {
                switch ($key) {
                    case 'db_field_name':
                        if (isset($val)) {
                            $this->setDbFieldName($val);
                        }
                        break;
                    case 'required':
                        if (isset($val)) {
                            $this->setRequired($val);
                        }
                        break;
                    case 'title':
                        if (isset($val)) {
                            $this->setTitle($val);
                        }
                        break;
                    case 'val':
                        if (isset($val)) {
                            $this->setVal($val);
                        }
                        break;
                    case 'not_selected_text':
                        if (isset($val)) {
                            $this->setDefaultText($val);
                        }
                        break;
                    case 'position':
                        if (isset($val)) {
                            $this->setPosition($val);
                        }
                        break;
                    case 'input_messages_position':
                        if (isset($val)) {
                            $this->setMessagePosition($val);
                        }
                        break;
                    case 'checkbox':
                        if (isset($val)) {
                            $this->setCheckbox($val);
                        }
                        break;
                }
            }
        }
    }

    /*
        Можно ли в селекте выбирать несколько позиций
    */
    public function setCheckbox($bool = false) : void {
        $this->settings['checkbox'] = $bool;
    }

    /*
        Можно ли в селекте выбирать несколько позиций. Метод возвращает bool
    */
    public function getCheckbox() : bool {
        return $this->settings['checkbox'];
    }

    /*
        Установить title
    */
    public function setTitle(string $title) : void {
        $this->settings['title'] = $title;
    }

    /*
        Вернуть title
    */
    public function getTitle() : string|null {
        return $this->settings['title'];
    }

    /*
        Устанавливает название списка
    */
    public function setDbFieldName($db_field_name) : void {
        $this->settings['db_field_name'] = $db_field_name;
    }

    /*
        Получает название списка
    */
    public function getDbFieldName() : string|null {
        return $this->settings['db_field_name'];
    }


    /*
        Устанавливает значение value в инпут
    */
    public function setVal(int|string|array|null $val) : void {
        if ($val) {
            $this->settings['val'] = $val;
        }
    }

    /*
        Возвращает установленное значение value
    */
    public function getVal() : string|array|int|null {
        return $this->settings['val'];
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

    /*
        Получает список элементов
    */
    public function getItems() : array|null {
        return $this->items;
    }

    /*
        Метод устанавливает логическое значение
        Обязателен ли для заполнения данный селект
    */
    public function setRequired($bool = false) : void {
        $this->settings['required'] = $bool;
    }

    /*
        Метод возвращает логическое значение
        Обязателен ли для заполнения данный селект
    */
    public function getRequired() : bool|null {
        return $this->settings['required'];
    }

    /*
        Метод устанавливает значение дефолтного текста
    */
    public function setDefaultText(string $text) : void {
        $this->settings['not_selected_text'] = $text;
    }

    /*
        Метод возвращает значение дефолтного текста
    */
    public function getDefaultText() : string|null {
        return $this->settings['not_selected_text'];
    }


    /*
        Метод устанавливает отображение выпадающего списка. Верху или снизу
    */
    public function setPosition($position = 'bottom') : void {
        $this->settings['position'] = $position;
    }

    /*
        Метод возвращает отображение выпадающего списка
    */
    public function getPosition() : string|null {
        return $this->settings['position'];
    }

     /*
        Метод устанавливает позицию (над селектом или под) информации об ошибках
    */
    public function setMessagePosition($position = 'bottom') : void {
        $this->settings['input_messages_position'] = $position;
    }

    /*
        Метод возвращает позицию (над селектом или под) информации об ошибках
    */
    public function getMessagePosition() : string|null {
        return $this->settings['input_messages_position'];
    }

    /*
        Метод возвращает настроенный массив для компонента .select
    */
    public function toArray() {
        $select_array['settings'] = $this->settings;
        $select_array['items'] = $this->getItems();

        return $select_array;
    }

    /*
        Возвращает отрендеренный элемент
    */
    public function toHtml() : string {
        return $this->WWCrmService->get('View')->render('components/select.twig', $this->toArray());
    }

}