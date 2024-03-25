<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class ObjEquipments extends Model {

  // Разрешенные для записи поля
  protected $fillable = [
    'object_id',
    'equipment_id',
    'field_properties_data'
  ];

  /*
    Получает справочник
  */
  public function getBookEquipments() {
    return $this->belongsTo('\WWCrm\Models\BookEquipments', 'equipment_id', 'id');
  }

}