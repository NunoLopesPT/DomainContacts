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
class RunScripts
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function migrate(): void
    {
        // Fix this helper is not autoloaded.
        require_once (__DIR__ . '/../../../vendor/illuminate/support/helpers.php');

        MigrationsServiceFactory::get()->runMigrations();
    }

    /**
     * Seed the database.
     */
    public static function seed(): void
    {
        // Fix this helper is not autoloaded.
        require_once (__DIR__ . '/../../../vendor/illuminate/support/helpers.php');

        MigrationsServiceFactory::get()->seedDatabase();
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
