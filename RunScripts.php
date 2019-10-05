<?php

use NunoLopes\Database\DomainContacts\Factories\Services\MigrationsServiceFactory;
use NunoLopes\Database\DomainContacts\Factories\Services\SeedsServiceFactory;
use NunoLopes\DomainContacts\Utilities\Signatures\Sha256RsaSignature;

/**
 * Class RunScripts.
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
        require_once(__DIR__ . '/vendor/illuminate/support/helpers.php');

        MigrationsServiceFactory::get()->runMigrations();
    }

    /**
     * Seed the database.
     */
    public static function seed(): void
    {
        // Fix this helper is not autoloaded.
        require_once(__DIR__ . '/vendor/illuminate/support/helpers.php');

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
        require_once(__DIR__ . '/vendor/illuminate/support/helpers.php');

        MigrationsServiceFactory::get()->rollbackMigrations();
    }

    /**
     * Generates a new KeyPair in the storage folder.
     *
     * @return void
     */
    public static function generateKeyPair(): void
    {
        $config = array(
            "digest_alg"       => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        // Create the private and public key
        $res = openssl_pkey_new($config);

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];

        // Store the private and the public key in the filesystem.
        \file_put_contents(
            __DIR__ . '/storage/oauth-private.key',
            $privKey
        );
        \file_put_contents(
            __DIR__ . '/storage/oauth-public.key',
            $pubKey
        );
    }
}
