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

  /*
    Возвращаем должность по его id
  */
  public static function getPostName($post_id = false) {
    if ($post_id === self::POST_STATUS_DIRECTOR) {
      return 'Руководитель';
    } elseif ($post_id === self::POST_STATUS_DEFAULT) {
      return 'Должность не задана';
    } else {
      return false;
    }
  }

  /*
    Получить все должности в виде массива
  */
  public static function getArrayPosts() {
    return [
      self::POST_STATUS_DIRECTOR => self::getPostName(self::POST_STATUS_DIRECTOR),
      self::POST_STATUS_DEFAULT => self::getPostName(self::POST_STATUS_DEFAULT)
    ];
  }

  protected $fillable = [
    'organization_id',
    'name',
    'surname',
    'patronymic',
    'tel',
    'email',
    'birth',
    'post',
    'post_id',
    'user_add_id'
  ];

  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }
}