<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use WWCrm\Models\Objects;

final class CreateObjectsTable extends AbstractMigration
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
        
        $default_status = Objects::STATUS_ACTIVE;

        $sql = "CREATE TABLE IF NOT EXISTS `objects` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `organization_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'Организация к которой принадлежит объект',
            `status` INT NOT NULL DEFAULT '{$default_status}' COMMENT 'Статус объекта',
            `brand` VARCHAR(255) DEFAULT NULL COMMENT 'Модель объекта',
            `model` VARCHAR(255) DEFAULT NULL COMMENT 'Марка объекта',
            `gnum` VARCHAR(20) DEFAULT NULL COMMENT 'Гос.номер объекта',
            `vin` VARCHAR(100) DEFAULT NULL COMMENT 'Вин.номер',
            `year` YEAR DEFAULT NULL COMMENT 'Год выпуска',
            `color` VARCHAR(20) DEFAULT NULL COMMENT 'Цвет',
            `reg_doc_num` VARCHAR(100) DEFAULT NULL COMMENT 'Номер документа о регистрации',
            `user_add_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'Кто добавил',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);

          $sql_alert = "
            ALTER TABLE `objects`
                ADD KEY `objects_organization_id_foreign` (`organization_id`),
                ADD KEY `objects_user_add_id_foreign` (`user_add_id`),
                ADD CONSTRAINT `objects_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
                ADD CONSTRAINT `objects_user_add_id_foreign` FOREIGN KEY (`user_add_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
          ";
          $this->execute($sql_alert);

          $seed = "INSERT INTO `objects` (`id`, `organization_id`, `status`, `brand`, `model`, `gnum`, `vin`, `year`, `color`, `reg_doc_num`, `user_add_id`, `created_at`, `updated_at`) VALUES (1, 1, $default_status, 'Бренд 1', 'Газ 1', '134234', '124253445', 2024, 'Синий', '3945023528345', 1, '2024-03-25 09:03:56', '2024-03-25 09:03:56')";

          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS objects";
  
  
          $this->execute($sql);
    }
}
