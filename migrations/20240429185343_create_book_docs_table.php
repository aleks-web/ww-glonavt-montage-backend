<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBookDocsTable extends AbstractMigration
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

        $sql = "CREATE TABLE IF NOT EXISTS `book_docs` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL COMMENT 'Название типа документа',
            `description` VARCHAR(255) DEFAULT NULL COMMENT 'Описание типа документа',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);

          $seed = "INSERT INTO `book_docs` (`id`, `name`, `description`) VALUES (1, 'Тип документа 1', 'Описание документа 1')";

          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS book_docs";
  
  
          $this->execute($sql);
    }
}
