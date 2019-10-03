<?php
namespace NunoLopes\DomainContacts\Factories\Datatypes;

use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;

/**
 * Class AsymmetricCryptographyFactory.
 *
 * @package NunoLopes\DomainContacts
 */
class AsymmetricCryptographyFactory
{
    /**
     * @var AsymmetricCryptography $crypt - AsymmetricCryptography instance with a key pair.
     */
    private static $crypt = null;

    /**
     * Creates an AsymmetricCryptography Service Instance.
     *
     * @return AsymmetricCryptography
     */
    private static function create(): AsymmetricCryptography
    {
        $privKey = \openssl_pkey_get_private(__DIR__ . '/../../../storage/oauth-private.key');
        $pubKey  = \openssl_pkey_get_public(__DIR__ . '/../../../storage/oauth-private.key');

        return new AsymmetricCryptography($pubKey, $privKey);
    }

    /**
     * Gets a Singleton Migration Service Instance.
     *
     * @return AsymmetricCryptography
     */
    public static function get(): AsymmetricCryptography
    {
        if (self::$crypt === null) {
            self::$crypt = self::create();
        }

        return self::$crypt;
    }
}
