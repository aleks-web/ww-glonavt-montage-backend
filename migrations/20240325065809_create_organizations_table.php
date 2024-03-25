<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use WWCrm\Models\Organizations;

final class CreateOrganizationsTable extends AbstractMigration
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
        // Статус создаваемой организации по умолчанию
        $default_status = Organizations::STATUS_ACTIVE;

        $sql = "CREATE TABLE IF NOT EXISTS `organizations` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) DEFAULT NULL COMMENT 'Имя организации',
            `status` INT NOT NULL DEFAULT '{$default_status}' COMMENT 'Статус организации',
            `inn` VARCHAR(150) DEFAULT NULL COMMENT 'ИНН организации',
            `email` VARCHAR(50) DEFAULT NULL COMMENT 'Email организации',
            `legal_address` VARCHAR(355) DEFAULT NULL COMMENT 'Юредический адрес',
            `actual_address` VARCHAR(355) DEFAULT NULL COMMENT 'Фактический адрес',
            `bank_name` VARCHAR(255) DEFAULT NULL COMMENT 'Название банка',
            `bic` VARCHAR(20) DEFAULT NULL COMMENT 'БИК банка',
            `checking_bill_num` VARCHAR(100) DEFAULT NULL COMMENT 'Номер рассчетного счета',
            `correspondent_bill_num` VARCHAR(100) DEFAULT NULL COMMENT 'Номер корреспондентского счета',
            `okpo` VARCHAR(100) DEFAULT NULL COMMENT 'Номер ОКПО',
            `okato` VARCHAR(100) DEFAULT NULL COMMENT 'Номер окато',
            `manager_id` BIGINT(20) UNSIGNED DEFAULT NULL COMMENT 'Ответственный менеджер. Id пользователя в системе',
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
          
          // Создаем таблицу
          $this->execute($sql);

          $seed = "INSERT INTO `organizations` (`id`, `name`, `status`, `inn`, `email`, `legal_address`, `actual_address`, `bank_name`, `bic`, `checking_bill_num`, `correspondent_bill_num`, `okpo`, `okato`, `manager_id`, `created_at`, `updated_at`) VALUES (1, 'Алексей', 20, '15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-25 06:03:50', '2024-03-25 06:03:50')";
          
          // Сеем тестовые данные
          $this->execute($seed);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS organizations";
  
  
          $this->execute($sql);
    }
}
