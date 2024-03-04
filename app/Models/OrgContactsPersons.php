<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class OrgContactsPersons extends Model {

  protected $fillable = [
    'organization_id',
    'name',
    'surname',
    'patronymic',
    'tel',
    'email',
    'birth',
    'user_add_id'
  ];

  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }
}