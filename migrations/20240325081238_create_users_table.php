<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

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

        $sql = "CREATE TABLE IF NOT EXISTS `users` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL COMMENT 'Имя пользователя',
            `surname` VARCHAR(60) DEFAULT NULL COMMENT 'Фамилия пользователя',
            `patronymic` VARCHAR(60) DEFAULT NULL COMMENT 'Отчество пользователя',
            `tel` VARCHAR(20) DEFAULT NULL COMMENT 'Телефон пользователя',
            `email` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Email пользователя',
            `birth` DATE DEFAULT NULL COMMENT 'День рождения пользователя',
            `password` VARCHAR(500) NOT NULL COMMENT 'Пароль пользователя',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
          
          // Создаем таблицу
          $this->execute($sql);

          $seed = 'INSERT INTO `users` (`name`, `surname`, `patronymic`, `tel`, `email`, `birth`, `password`) VALUES ("Алексей", "Антропов", "Андреевич", "89195798871", "dok.go@yandex.ru", NULL, "$2y$10$oRPfzOL0FRvfqPxrD5ftJ.Op64GxMD9c1SyDgVgSU8gLe6WgCu8Oa")';
          
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
