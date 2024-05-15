<?php

namespace WWCrm\Models;

use \Illuminate\Database\Eloquent\Model;

class OrgContracts extends Model {

  // ВНИМАНИЕ! ЭТИ Id пишуться в бд. Изменять их строго запрещено! Только добавлять новые!
  // Ключ - это id, значение - текстовое наименование
  const BOOK_TYPES = [
    10 => "Договор на поставку и выполнение пуско-наладочных работ оборудования для транспортных средств.",
    20 => "Договор монтажа и замены блоков СКЗИ тахографа (разовый)",
    30 => "Договора поставки карт",
    40 => "Договора купли-продажи, поставки оборудования",
    50 => "Информационное обслуживание системы спутникового мониторинга и видеонаблюдения",
    60 => "Договор на оказание сервисных услуг (работ) по установке, проверке, техническому обслуживанию и ремонту технических средств контроля труда и отдыха водителей, устанавливаемых на автотранспортных средствах.",
    70 => "Договор на поставку, установку оборудования системы спутникового мониторинга для транспортных средств"
  ];

  protected $fillable = [
    'organization_id',
    'contract_file_name',
    'doc_type_id',
    'contract_num',
    'contract_date_start',
    'contract_date_end',
    'responsible_user_id'
  ];

  public static function getFillableAttributes(): array {
    return (new static)->getFillable();
  }

  public function responsibleUser() {
    return $this->belongsTo('\WWCrm\Models\Users', 'responsible_user_id', 'id');
  }

  public function docType() {
    return $this->belongsTo('\WWCrm\Models\BookDocs', 'book_doc_id', 'id');
  }
}