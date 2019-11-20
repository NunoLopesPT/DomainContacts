<?php
namespace NunoLopes\DomainContacts\Factories\Services;

use NunoLopes\DomainContacts\Factories\Repositories\Database\AccessTokenRepositoryFactory;
use NunoLopes\DomainContacts\Services\AccessTokenService;

/**
 * Class AccessTokenServiceFactory.
 *
 * This class will be used to create an AccessTokenService instance.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenServiceFactory
{
    /**
     * @var AccessTokenService $service - Singleton instance of ContactsRepository.
     */
    private static $service = null;

    /**
     * Create a new AccessTokenService instance.
     *
     * @return AccessTokenService
     */
    private static function create(): AccessTokenService
    {
        return new AccessTokenService(
            AccessTokenRepositoryFactory::get(),
            AuthenticationTokenServiceFactory::get()
        );
    }

    /**
     * Get a new AccessTokenService instance if not found or
     * return the one already created (Singleton).
     *
     * @return AccessTokenService
     */
    public static function get(): AccessTokenService
    {
        if (self::$service === null) {
            self::$service = self::create();
        }

        return self::$service;
    }
}
