<?php declare(strict_types=1);

namespace SwagBundleElement\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1683635022 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1683635022;
    }

    public function update(Connection $connection): void
    {
        $query = <<<SQL
                    CREATE TABLE `bundle_element` (
                        `id` BINARY(16) NOT NULL,
                        `discount_type` VARCHAR(255) NOT NULL,
                        `discount` VARCHAR(255) NULL,
                        `quantity` VARCHAR(255) NULL,
                        `product_id` BINARY(16) NULL,
                        `product_version_id` BINARY(16) NULL,
                        `created_at` DATETIME(3) NOT NULL,
                        `updated_at` DATETIME(3) NULL,
                        PRIMARY KEY (`id`),
                        KEY `fk.bundle_element.product_id` (`product_id`,`product_version_id`),
                        CONSTRAINT `fk.bundle_element.product_id` FOREIGN KEY (`product_id`,`product_version_id`) REFERENCES `product` (`id`,`version_id`) ON DELETE CASCADE ON UPDATE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                    
                    CREATE TABLE `bundle_element_translation` (
                        `position` VARCHAR(255) NOT NULL,
                        `created_at` DATETIME(3) NOT NULL,
                        `updated_at` DATETIME(3) NULL,
                        `bundle_element_id` BINARY(16) NOT NULL,
                        `language_id` BINARY(16) NOT NULL,
                        PRIMARY KEY (`bundle_element_id`,`language_id`),
                        KEY `fk.bundle_element_translation.bundle_element_id` (`bundle_element_id`),
                        KEY `fk.bundle_element_translation.language_id` (`language_id`),
                        CONSTRAINT `fk.bundle_element_translation.bundle_element_id` FOREIGN KEY (`bundle_element_id`) REFERENCES `bundle_element` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT `fk.bundle_element_translation.language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                    
                    CREATE TABLE `bundle` (
                        `id` BINARY(16) NOT NULL,
                        `active` TINYINT(1) NULL DEFAULT '0',
                        `bundle_element_id` BINARY(16) NULL,
                        `created_at` DATETIME(3) NOT NULL,
                        `updated_at` DATETIME(3) NULL,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                    
                    CREATE TABLE `bundle_translation` (
                        `name` VARCHAR(255) NOT NULL,
                        `description` VARCHAR(255) NOT NULL,
                        `headline` VARCHAR(255) NOT NULL,
                        `position` VARCHAR(255) NOT NULL,
                        `created_at` DATETIME(3) NOT NULL,
                        `updated_at` DATETIME(3) NULL,
                        `bundle_id` BINARY(16) NOT NULL,
                        `language_id` BINARY(16) NOT NULL,
                        PRIMARY KEY (`bundle_id`,`language_id`),
                        KEY `fk.bundle_translation.bundle_id` (`bundle_id`),
                        KEY `fk.bundle_translation.language_id` (`language_id`),
                        CONSTRAINT `fk.bundle_translation.bundle_id` FOREIGN KEY (`bundle_id`) REFERENCES `bundle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                        CONSTRAINT `fk.bundle_translation.language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                SQL;
                $connection->executeStatement($query);
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
