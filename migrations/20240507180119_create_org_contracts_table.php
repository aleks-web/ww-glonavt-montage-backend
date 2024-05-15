<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateOrgContractsTable extends AbstractMigration
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

        $sql = "CREATE TABLE IF NOT EXISTS `org_contracts` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `organization_id` BIGINT UNSIGNED NOT NULL COMMENT 'Организация к которой принадлежит документ',
            `doc_type_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'Id типа документа. Типы объявлены в классе',
            `contract_num` VARCHAR(500) NOT NULL COMMENT 'Номер договора',
            `contract_date_start` DATE DEFAULT NULL COMMENT 'Дата начала договора',
            `contract_date_end` DATE DEFAULT NULL COMMENT 'Дата окончания договора',
            `responsible_user_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'Ответственный',
            `contract_file_name` VARCHAR(500) DEFAULT NULL COMMENT 'Название файла договора',
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Создаем таблицу
          $this->execute($sql);


          $sql_alert = "
            ALTER TABLE `org_contracts`
                ADD KEY `org_contracts_organization_id_foreign` (`organization_id`),
                ADD KEY `org_contracts_responsible_user_id_foreign` (`responsible_user_id`),
                ADD CONSTRAINT `org_contracts_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
                ADD CONSTRAINT `org_contracts_responsible_user_id_foreign` FOREIGN KEY (`responsible_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
          ";
          $this->execute($sql_alert);



          $seed = "INSERT INTO `org_contracts` (`organization_id`, `contract_num`, `responsible_user_id`) VALUES (1, '23989423', 1)";

          // Сеем тестовые данные
          $this->execute($seed);
    }

    // Откат
    public function down(): void {
        $sql = "DROP TABLE IF EXISTS org_contracts";
        $this->execute($sql);
    }
}
