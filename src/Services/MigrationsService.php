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
        // If there is no table for migrations created already, we need to create it.
        if (!$this->migrator->repositoryExists()) {
            $this->migrator->getRepository()->createRepository();
        }

        // Run all migrations inside migrations folder.
        return $this->migrator->run(__DIR__ . '/../../database/migrations');
    }

    /**
     * Rollback migrations.
     *
     * @return array
     */
    public function rollbackMigrations(): array
    {
        return $this->migrator->reset();
    }
}
