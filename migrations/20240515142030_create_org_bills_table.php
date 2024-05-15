<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateOrgBillsTable extends AbstractMigration
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

        $sql = "CREATE TABLE IF NOT EXISTS `org_bills` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `contract_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'id договора',
            `sum` DECIMAL(10, 2) UNSIGNED DEFAULT NULL COMMENT 'Сумма счета',
            `comment` VARCHAR(500) DEFAULT NULL COMMENT 'Комментарий к счету',
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

          // Сеем тестовые данные
          $this->execute($sql);
    }

    // Откат
    public function down(): void {
        $this->execute("DROP TABLE IF EXISTS org_bills");
    }
}
