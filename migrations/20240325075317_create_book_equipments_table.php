<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use WWCrm\Models\BookEquipments;

final class CreateBookEquipmentsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        $default_status = BookEquipments::STATUS_ACTIVE;

        $sql = "CREATE TABLE IF NOT EXISTS `book_equipments` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `status` INT NOT NULL DEFAULT '{$default_status}' COMMENT 'Статус оборудования',
            `name` VARCHAR(255) DEFAULT NULL COMMENT 'Название оборудования',
            `field_properties` json DEFAULT NULL COMMENT 'Характеристики полей оборудования',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
          
          // Создаем таблицу
          $this->execute($sql);

          $seed = "INSERT INTO `book_equipments` (`id`, `status`, `name`, `field_properties`, `created_at`, `updated_at`) VALUES (1, 1, 'Оборудование 1', '[{\"pls\": \"Плейсхолдер 1\", \"name\": \"Имя 1\", \"type\": \"input-text\", \"db_field_name\": \"name1\"}, {\"pls\": \"Плейсхолдер 2\", \"name\": \"Имя 2\", \"type\": \"input-text\", \"db_field_name\": \"name2\"}, {\"pls\": \"Плейсхолдер date\", \"name\": \"Дата\", \"type\": \"input-text\", \"db_field_name\": \"date\"}]', '2024-03-25 07:46:58', '2024-03-25 07:46:58')";
          
          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS book_equipments";
  
  
          $this->execute($sql);
    }
}
