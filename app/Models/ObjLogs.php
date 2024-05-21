<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class ObjLogs extends Model {

    /*
        ID события. Создание
    */
    const EVENT_CREATE = 10;

    /*
        ID события. Обновление
    */
    const EVENT_UPDATE = 20;

    /*
        ID события. Добавление в архив
    */
    const EVENT_ARCHIVE = 30;

    // Название таблицы в БД
    protected $table = 'obj_logs';

    // Разрешенные для записи поля
    protected $fillable = [
        'object_id',
        'event_id',
        'user_add_id',
    ];

}