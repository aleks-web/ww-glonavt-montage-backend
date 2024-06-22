<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateApplicationsTable extends AbstractMigration
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
    public function up(): void {

        $sql = "CREATE TABLE IF NOT EXISTS `applications` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `object_id` BIGINT UNSIGNED NOT NULL COMMENT 'id объекта, к которому принадлежит заявка',
            `status` INT NOT NULL DEFAULT '0' COMMENT 'Статус заявки',
            `user_add_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'Кто создал заявку',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);

          $sql_alert = "
            ALTER TABLE `applications`
                ADD KEY `applications_object_id_foreign` (`object_id`),
                ADD KEY `applications_user_add_id_foreign` (`user_add_id`),

                ADD CONSTRAINT `applications_object_id_foreign` FOREIGN KEY (`object_id`) REFERENCES `objects` (`id`) ON DELETE CASCADE,
                ADD CONSTRAINT `applications_user_add_id_foreign` FOREIGN KEY (`user_add_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
          ";
          $this->execute($sql_alert);

          $seed = "INSERT INTO `applications` (`id`, `object_id`, `status`, `user_add_id`, `created_at`, `updated_at`) VALUES (1, 1, 0, 1, '2024-03-25 09:03:56', '2024-03-25 09:03:56')";

          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void {
        $sql = "DROP TABLE IF EXISTS applications";
        $this->execute($sql);
    }
}
