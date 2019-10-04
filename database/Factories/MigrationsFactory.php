<?php
namespace NunoLopes\Database\DomainContacts\Factories;

use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\Filesystem;
use NunoLopes\DomainContacts\Factories\Database\Eloquent\CapsuleFactory;

/**
 * Class MigrationsFactory.
 *
 * This class will create a singleton instance to deal with the migrations.
 *
 * @package NunoLopes\DomainContacts
 */
class MigrationsFactory
{
    /**
     * @var $instance Migrator - Singleton instance of Migrator.
     */
    private static $instance = null;

    /**
     * Returns a new instance of Migrator.
     *
     * @return Migrator
     */
    private static function create(): Migrator
    {
        // Creates the resolver with a default connection to the database.
        $resolver = new ConnectionResolver([
            'default' => CapsuleFactory::get()->getConnection()
        ]);

        // Starts the DatabaseMigrations repository with the
        // migrations table
        $repository = new DatabaseMigrationRepository(
            $resolver,
            'migrations'
        );

        // Set the database connection default to use in the repository.
        $repository->setSource('default');

        // Start the Migrator.
        $migrator = new Migrator(
            $repository,
            $resolver,
            new Filesystem()
        );

        // Set the database connection default to use in the repository.
        $migrator->setConnection('default');

        return $migrator;
    }

    /**
     * Get a new Migrator instance if not found or
     * return the one already created (Singleton).
     *
     * @return Migrator
     */
    public static function get(): Migrator
    {
        if (self::$instance === null) {
            self::$instance = self::create();
        }

        return self::$instance;
    }
}
