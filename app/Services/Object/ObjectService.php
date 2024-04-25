<?php

namespace WWCrm\Services\Object;

// Объекты
use WWCrm\Models\Organizations;

final class ObjectService extends MainService {

    /*
        Получить html отрендеренный компонент со списком пользователей
    */
    public function getComponentSelect(string $component_input_name = null, bool $required = null) : false|string {
        return 'test';
    }
}