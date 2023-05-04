<?php declare(strict_types=1);

namespace SwagBlogFinder\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1682594291 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1682594291;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement("
            CREATE TABLE `blog_category` (
            `id` BINARY(16) NOT NULL,
            `created_at` DATETIME(3) NOT NULL,
            `updated_at` DATETIME(3) NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        CREATE TABLE `blog_category_translation` (
        `name` VARCHAR(255) NOT NULL,
        `created_at` DATETIME(3) NOT NULL,
        `updated_at` DATETIME(3) NULL,
        `blog_category_id` BINARY(16) NOT NULL,
        `language_id` BINARY(16) NOT NULL,
        PRIMARY KEY (`blog_category_id`,`language_id`),
        KEY `fk.blog_category_translation.blog_category_id` (`blog_category_id`),
        KEY `fk.blog_category_translation.language_id` (`language_id`),
        CONSTRAINT `fk.blog_category_translation.blog_category_id` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT `fk.blog_category_translation.language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        CREATE TABLE `blog_finder` (
        `id` BINARY(16) NOT NULL,
        `release_date` DATETIME(3) NULL,
        `active` TINYINT(1) NULL DEFAULT '0',
        `blog_category_id` BINARY(16) NULL,
        `Author` VARCHAR(255) NULL,
        `created_at` DATETIME(3) NOT NULL,
        `updated_at` DATETIME(3) NULL,
        PRIMARY KEY (`id`),
        KEY `fk.blog_finder.blog_category_id` (`blog_category_id`),
        CONSTRAINT `fk.blog_finder.blog_category_id` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_finder_translation` (
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    `blog_finder_id` BINARY(16) NOT NULL,
    `language_id` BINARY(16) NOT NULL,
    PRIMARY KEY (`blog_finder_id`,`language_id`),
    KEY `fk.blog_finder_translation.blog_finder_id` (`blog_finder_id`),
    KEY `fk.blog_finder_translation.language_id` (`language_id`),
    CONSTRAINT `fk.blog_finder_translation.blog_finder_id` FOREIGN KEY (`blog_finder_id`) REFERENCES `blog_finder` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.blog_finder_translation.language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_finder_mapping` (
    `blog_finder_id` BINARY(16) NOT NULL,
    `product_id` BINARY(16) NOT NULL,
    `product_version_id` BINARY(16) NULL,
    PRIMARY KEY (`blog_finder_id`,`product_id`),
    KEY `fk.blog_finder_mapping.product_id` (`product_id`,`product_version_id`),
    KEY `fk.blog_finder_mapping.blog_finder_id` (`blog_finder_id`),
    CONSTRAINT `fk.blog_finder_mapping.product_id` FOREIGN KEY (`product_id`,`product_version_id`) REFERENCES `product` (`id`,`version_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk.blog_finder_mapping.blog_finder_id` FOREIGN KEY (`blog_finder_id`) REFERENCES `blog_finder` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
