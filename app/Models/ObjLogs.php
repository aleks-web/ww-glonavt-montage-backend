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
        Возвращаем статус по его id
    */
    public static function getStatusName($status_id = false) {
        if ($status_id === self::EVENT_CREATE) {
            return 'Создание объекта';
        } elseif ($status_id === self::EVENT_UPDATE) {
            return 'Обновление объекта';
        } else {
            return false;
        }
    }

    /*
        Возвращаем id статуса по его названию
    */
    public static function getStatusId($status_name = false) {
        if ($status_name === 'EVENT_CREATE') {
            return self::EVENT_CREATE;
        } elseif ($status_name === 'EVENT_UPDATE') {
            return self::EVENT_UPDATE;
        } else {
            return false;
        }
    }

    /*
        Получить все статусы в виде массива
    */
    public static function getArrayStatuses() {
        return [
            self::EVENT_CREATE => self::getStatusName(self::EVENT_CREATE),
            self::EVENT_UPDATE => self::getStatusName(self::EVENT_UPDATE),
        ];
    }

    /*
        Получить все статусы в виде именованного массива
    */
    public static function getArrayStatusesNamed() {
        return [
            'EVENT_CREATE' => self::getStatusId('EVENT_CREATE'),
            'EVENT_UPDATE' => self::getStatusId('EVENT_UPDATE'),
        ];
    }




    // Название таблицы в БД
    protected $table = 'obj_logs';

    // Разрешенные для записи поля
    protected $fillable = [
        'object_id',
        'event_id',
        'user_add_id',
    ];

    // Объект
    public function object() {
        return $this->belongsTo('\WWCrm\Models\Objects', 'object_id', 'id');
    }

    // Пользователь
    public function userAdded() {
        return $this->belongsTo('\WWCrm\Models\Users', 'user_add_id', 'id');
    }
}