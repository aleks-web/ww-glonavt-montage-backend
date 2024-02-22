<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class Clients extends Model {
  protected $fillable = [
    'name',
    'status',
    'inn',
    'director_tel',
    'director_fio',
    'email',
    'legal_address',
    'actual_address',
    'bank_id',
    'bic',
    'checking_bill_num',
    'correspondent_bill_num',
    'okpo',
    'okato',
    'manager_id'
  ];


  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }
}