<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateObjLogsTable extends AbstractMigration
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

        $sql = "CREATE TABLE IF NOT EXISTS `obj_logs` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `object_id` BIGINT UNSIGNED NOT NULL COMMENT 'Объект на котором прошел лог',
            `event_id` BIGINT UNSIGNED NOT NULL COMMENT 'id события',
            `user_add_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'Кто добавил',
            `log_data` JSON DEFAULT NULL COMMENT 'Доп.инф для лога',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);

          $sql_alert = "
            ALTER TABLE `obj_logs`
            ADD KEY `obj_logs_object_id_foreign` (`object_id`),
            ADD KEY `obj_logs_user_add_id_foreign` (`user_add_id`),

            ADD CONSTRAINT `obj_logs_object_id_foreign` FOREIGN KEY (`object_id`) REFERENCES `objects` (`id`) ON DELETE CASCADE,
            ADD CONSTRAINT `obj_logs_user_add_id_foreign` FOREIGN KEY (`user_add_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
          ";
          $this->execute($sql_alert);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS obj_logs";
  
  
          $this->execute($sql);
    }
}