<?php

namespace WWCrm\Services\Object;

// Главный сервис
use WWCrm\Services\MainService;

// Объекты
use WWCrm\Models\Organizations;

final class ObjectService extends MainService {

    /*
        Получить html отрендеренный компонент со списком пользователей
    */
    public static function getComponentSelect(string $component_input_name = null, bool $required = null) : false|string {
        
    }
}