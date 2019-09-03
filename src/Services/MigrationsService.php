<?php
namespace NunoLopes\DomainContacts\Services;

use Illuminate\Database\Migrations\Migrator;

/**
 * Class MigrationsService.
 *
 * This class will be the responsible for all migrations.
 *
 * @package NunoLopes\DomainContacts\Services
 */
class MigrationsService
{
    /**
     * @var Migrator $migrator - Migrator Instance.
     */
    private $migrator;

    /**
     * MigrationsService constructor.
     */
    public function __construct(Migrator $migrator)
    {
        $this->migrator = $migrator;
    }

    /**
     * Runs migrations.
     *
     * @return array
     */
    public function runMigrations(): array
    {
        echo "Running migrations...\n";

        // If there is no table for migrations created already, we need to create it.
        if (!$this->migrator->repositoryExists()) {
            $this->migrator->getRepository()->createRepository();

            echo "Migrations table created\n";
        }

        // Run all migrations inside migrations folder.
        $result = $this->migrator->run(__DIR__ . '/../../database/migrations');

        echo "Migrations created with success\n";

        return $result;
    }

    /**
     * Rollback migrations.
     *
     * @return array
     */
    public function rollbackMigrations(): array
    {
        echo "Rolling back migrations...\n";

        $result = $this->migrator->reset([__DIR__ . '/../../database/migrations']);

        echo "Migrations rolled back with success\n";

        return $result;
    }
}
