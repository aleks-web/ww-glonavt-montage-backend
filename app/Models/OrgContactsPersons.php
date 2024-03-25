<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class OrgContactsPersons extends Model {

  /*
    Статус директора
  */
  const POST_STATUS_DIRECTOR = 1;

  /*
    Статус по умолчанию
  */
  const POST_STATUS_DEFAULT = 0;

  protected $fillable = [
    'organization_id',
    'name',
    'surname',
    'patronymic',
    'tel',
    'email',
    'birth',
    'post',
    'is_director',
    'user_add_id'
  ];

  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }
}