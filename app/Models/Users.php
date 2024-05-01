<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class Users extends Model {

  /*
    Активный статус
  */
  const STATUS_ACTIVE = 20;

  /*
    Заблокирован
  */
  const STATUS_BLOCKED = 30;


  public $timestamps = false;

  protected $fillable = [
    'name',
    'surname',
    'patronymic',
    'avatar_file_name',
    'post_id',
    'tel',
    'email',
    'birth',
    'status',
    'password'
  ];

  // Должность
  public function post()
  {
      return $this->belongsTo('\WWCrm\Models\BookPosts', 'post_id', 'id');
  }

  /*
    Возвращаем статус по его id
  */
  public static function getStatusName($status_id = false) : string|false{
    if ($status_id === self::STATUS_ACTIVE) {
      return 'Активный';
    } elseif($status_id === self::STATUS_BLOCKED) {
      return 'Заблокирован';
    } else {
      return false;
    }
  }

  /*
    Возвращаем id статуса по его названию
  */
  public static function getStatusId($status_name = false) {
    if ($status_name === 'STATUS_ACTIVE') {
      return self::STATUS_ACTIVE;
    } elseif ($status_name === 'STATUS_BLOCKED') {
      return self::STATUS_BLOCKED;
    } else {
      return false;
    }
  }

  /*
    Получить все статусы в виде массива
  */
  public static function getArrayStatuses() {
    return [
      self::STATUS_ACTIVE => self::getStatusName(self::STATUS_ACTIVE),
      self::STATUS_BLOCKED => self::getStatusName(self::STATUS_BLOCKED),
    ];
  }

  /*
    Получить все статусы в виде именованного массива
  */
  public static function getArrayStatusesNamed() {
    return [
      'STATUS_ACTIVE' => self::getStatusId('STATUS_ACTIVE'),
      'STATUS_BLOCKED' => self::getStatusId('STATUS_BLOCKED'),
    ];
  }


}