<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

// Модель пользователя
use WWCrm\Models\Users;

final class CreateUsersTable extends AbstractMigration
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

        $default_status = Users::STATUS_ACTIVE;

        $sql = "CREATE TABLE IF NOT EXISTS `users` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL COMMENT 'Имя пользователя',
            `surname` VARCHAR(60) DEFAULT NULL COMMENT 'Фамилия пользователя',
            `patronymic` VARCHAR(60) DEFAULT NULL COMMENT 'Отчество пользователя',
            `status` INT NOT NULL DEFAULT '{$default_status}' COMMENT 'Статус пользователя',
            `post_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'Занимаемая должность',
            `tel` VARCHAR(15) DEFAULT NULL COMMENT 'Телефон пользователя',
            `email` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Email пользователя',
            `birth` DATE DEFAULT NULL COMMENT 'День рождения пользователя',
            `avatar_file_name` VARCHAR(255) DEFAULT NULL COMMENT 'Название файла аватарки пользователя',
            `password` VARCHAR(500) NOT NULL COMMENT 'Пароль пользователя',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
          
          // Создаем таблицу
          $this->execute($sql);

          $sql_alert = "
            ALTER TABLE `users`
                ADD KEY `users_post_id_foreign` (`post_id`),
                ADD CONSTRAINT `users_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `book_posts` (`id`) ON DELETE SET NULL
          ";
          $this->execute($sql_alert);

          $seed = 'INSERT INTO `users` (`name`, `surname`, `patronymic`, `tel`, `email`, `birth`, `password`, `post_id`, `avatar_file_name`) VALUES ("Алексей", "Антропов", "Андреевич", "89195798871", "dok.go@yandex.ru", NULL, "$2y$10$oRPfzOL0FRvfqPxrD5ftJ.Op64GxMD9c1SyDgVgSU8gLe6WgCu8Oa", 1, "alex_developer.jpg")';
          
          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS users";
  
  
          $this->execute($sql);
    }
}
