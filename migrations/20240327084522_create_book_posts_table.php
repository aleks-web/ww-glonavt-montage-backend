<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBookPostsTable extends AbstractMigration
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

        $sql = "CREATE TABLE IF NOT EXISTS `book_posts` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `department_id` BIGINT UNSIGNED NOT NULL COMMENT 'id отдела для которого создана должность',
            `name` VARCHAR(50) NOT NULL COMMENT 'Название отдела',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);

          $sql_alert = "
            ALTER TABLE `book_posts`
              ADD KEY `book_posts_department_id_foreign` (`department_id`),
              ADD CONSTRAINT `book_posts_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `book_departments` (`id`) ON DELETE CASCADE
          ";
          $this->execute($sql_alert);

          $seed = "INSERT INTO `book_posts` (`id`, `department_id`, `name`) VALUES (1, 1, 'Отдел 1')";

          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS book_posts";
  
  
          $this->execute($sql);
    }
}
