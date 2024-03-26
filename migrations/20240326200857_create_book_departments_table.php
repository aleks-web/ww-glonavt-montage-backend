<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBookDepartmentsTable extends AbstractMigration
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

        $sql = "CREATE TABLE IF NOT EXISTS `book_departments` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL COMMENT 'Название отдела',
            `description` VARCHAR(255) DEFAULT NULL COMMENT 'Описание отдела',
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);

          $seed = "INSERT INTO `book_departments` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES (1, 'Отдел 1', 'Описание отдела 1', '2024-03-25 09:23:40', '2024-03-25 09:23:40')";

          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS book_departments";
  
  
          $this->execute($sql);
    }
}
