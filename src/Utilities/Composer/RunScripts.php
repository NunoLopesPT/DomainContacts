<?php
namespace NunoLopes\DomainContacts\Utilities\Composer;

use NunoLopes\DomainContacts\Factories\Services\Database\MigrationsServiceFactory;
use NunoLopes\DomainContacts\Factories\Services\Database\SeedsServiceFactory;
use NunoLopes\DomainContacts\Utilities\Signatures\Sha256RsaSignature;

/**
 * Class Migrations.
 *
 * Utility class to help running migrations via composer script.
 *
 * @codeCoverageIgnore
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

        SeedsServiceFactory::get()->seedDatabase();
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

    /**
     * Generates a new KeyPair in the storage folder.
     *
     * @return void
     */
    public static function generateKeyPair(): void
    {
        $sign    = new Sha256RsaSignature();
        $keyPair = $sign->create();

        // Store the private and the public key in the filesystem.
        \file_put_contents(
            __DIR__ . '/../../../storage/oauth-private.key',
            $keyPair->privateKey()
        );
        \file_put_contents(
            __DIR__ . '/../../../storage/oauth-public.key',
            $keyPair->publicKey()
        );
    }
}
