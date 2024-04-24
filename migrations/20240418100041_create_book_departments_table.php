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
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);

          $seed = "INSERT INTO `book_departments` (`id`, `name`, `description`) VALUES (1, 'Отдел разработки', 'Занимается тех.поддержкой crm и её доработками')";

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
