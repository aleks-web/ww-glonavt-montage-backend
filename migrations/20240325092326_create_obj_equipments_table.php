<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateObjEquipmentsTable extends AbstractMigration
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

        $sql = "CREATE TABLE IF NOT EXISTS `obj_equipments` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `object_id` BIGINT UNSIGNED NOT NULL COMMENT 'ID объекта',
            `equipment_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'ID позиции из справочника',
            `field_properties_data` JSON DEFAULT NULL COMMENT 'Характеристики полей оборудования - заполнение по шаблону',
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);

          $sql_alert = "
            ALTER TABLE `obj_equipments`
                ADD KEY `obj_equipments_object_id_foreign` (`object_id`),
                ADD KEY `obj_equipments_equipment_id_foreign` (`equipment_id`),
                ADD CONSTRAINT `obj_equipments_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `book_equipments` (`id`) ON DELETE SET NULL,
                ADD CONSTRAINT `obj_equipments_object_id_foreign` FOREIGN KEY (`object_id`) REFERENCES `objects` (`id`) ON DELETE CASCADE
          ";
          $this->execute($sql_alert);

          $seed = "INSERT INTO `obj_equipments` (`id`, `object_id`, `equipment_id`, `field_properties_data`, `created_at`, `updated_at`) VALUES (1, 1, 1, '[[{\"val\": \"Имя 1 значение\", \"db_field_name\": \"name1\"}, {\"val\": \"Имя 2 значение\", \"db_field_name\": \"name2\"}, {\"val\": \"01-02-2024\", \"db_field_name\": \"date\"}], [{\"val\": \"Имя 1 значение\", \"db_field_name\": \"name1\"}, {\"val\": \"Имя 2 значение\", \"db_field_name\": \"name2\"}, {\"val\": \"01-02-2024\", \"db_field_name\": \"date\"}], [{\"val\": \"Имя 1 значение\", \"db_field_name\": \"name1\"}, {\"val\": \"Имя 2 значение\", \"db_field_name\": \"name2\"}, {\"val\": \"01-02-2024\", \"db_field_name\": \"date\"}]]', '2024-03-25 09:23:40', '2024-03-25 09:23:40')";

          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS obj_equipments";
  
  
          $this->execute($sql);
    }
}
