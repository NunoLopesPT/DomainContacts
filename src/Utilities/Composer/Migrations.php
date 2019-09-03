<?php
namespace NunoLopes\DomainContacts\Utilities\Composer;

use NunoLopes\DomainContacts\Factories\Services\MigrationsServiceFactory;

/**
 * Class Migrations.
 *
 * Utility class to help running migrations via composer script.
 *
 * @package NunoLopes\DomainContacts
 */
class Migrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function run(): void
    {
        // Fix this helper is not autoloaded.
        require_once (__DIR__ . '/../../../vendor/illuminate/support/helpers.php');

        MigrationsServiceFactory::get()->runMigrations();
    }

    /**
     * Rollback migrations.
     *
     * @return void
     */
    public static function rollback(): void
    {
        // Fix this helper is not autoloaded.
        require_once (__DIR__ . '/../../../vendor/illuminate/support/helpers.php');

        MigrationsServiceFactory::get()->rollbackMigrations();
    }
}
