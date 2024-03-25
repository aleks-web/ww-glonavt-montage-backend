<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use WWCrm\Models\OrgContactsPersons;


final class CreateOrgContactsPersonsTable extends AbstractMigration
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
        
        $default_status = OrgContactsPersons::POST_STATUS_DEFAULT;

        $sql = "CREATE TABLE IF NOT EXISTS `org_contacts_persons` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `organization_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'Организация к которой относится контактное лицо',
            `name` VARCHAR(50) NOT NULL COMMENT 'Имя контактного лица',
            `surname` VARCHAR(60) DEFAULT NULL COMMENT 'Фамилия контактного лица',
            `patronymic` VARCHAR(60) DEFAULT NULL COMMENT 'Отчество контактного лица',
            `tel` VARCHAR(15) DEFAULT NULL COMMENT 'Телефон контактного лица',
            `email` VARCHAR(50) DEFAULT NULL COMMENT 'Email контактного лица',
            `birth` DATE DEFAULT NULL COMMENT 'День рождения контактного лица',
            `post` VARCHAR(100) DEFAULT NULL COMMENT 'Должность контактного лица',
            `is_director` TINYINT(4) NOT NULL DEFAULT '{$default_status}' COMMENT 'Является ли контактное лицо директором',
            `user_add_id` BIGINT(20) UNSIGNED DEFAULT NULL COMMENT 'Кто добавил',
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
          
          // Создаем таблицу
          $this->execute($sql);


          $sql_alert = "
            ALTER TABLE `org_contacts_persons`
              ADD KEY `org_contacts_persons_organization_id_foreign` (`organization_id`),
              ADD KEY `org_contacts_persons_user_add_id_foreign` (`user_add_id`),
              ADD CONSTRAINT `org_contacts_persons_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
              ADD CONSTRAINT `org_contacts_persons_user_add_id_foreign` FOREIGN KEY (`user_add_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
          ";
          $this->execute($sql_alert);

          $seed = "INSERT INTO `org_contacts_persons` (`id`, `organization_id`, `name`, `surname`, `patronymic`, `tel`, `email`, `birth`, `post`, `is_director`, `user_add_id`, `created_at`, `updated_at`) VALUES (1, 1, 'Игорь', 'Кузнецов', '', '89195798871', 'dok.go@yandex.ru', NULL, NULL, 0, 1, '2024-03-25 08:22:58', '2024-03-25 08:22:58')";
          
          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS org_contacts_persons";
  
  
          $this->execute($sql);
    }
}
