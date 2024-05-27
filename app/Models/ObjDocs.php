<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class ObjDocs extends Model {

    // Название таблицы в БД
    protected $table = 'obj_docs';

    // Разрешенные для записи поля
    protected $fillable = [
        'object_id',
        'comment',
        'name',
        'doc_file_name',
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