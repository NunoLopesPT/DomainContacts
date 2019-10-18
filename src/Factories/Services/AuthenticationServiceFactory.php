<?php
namespace NunoLopes\DomainContacts\Factories\Services;

use NunoLopes\DomainContacts\Factories\Repositories\Database\UsersRepositoryFactory;
use NunoLopes\DomainContacts\Factories\Utilities\AuthenticationFactory;
use NunoLopes\DomainContacts\Services\AuthenticationService;

/**
 * Class AuthenticationServiceFactory.
 *
 * This class will be used to create an AuthenticationService instance.
 *
 * @package NunoLopes\DomainContacts
 */
class AuthenticationServiceFactory
{
    /**
     * @var AuthenticationService $service - Singleton instance of AuthenticationService.
     */
    private static $service = null;

    /**
     * Create a new AuthenticationService instance.
     *
     * @return AuthenticationService
     */
    private static function create(): AuthenticationService
    {
        return new AuthenticationService(
            UsersRepositoryFactory::get(),
            AccessTokenServiceFactory::get(),
            AuthenticationFactory::get()
        );
    }

    /**
     * Get a new AuthenticationService instance if not found or
     * return the one already created (Singleton).
     *
     * @return AuthenticationService
     */
    public static function get(): AuthenticationService
    {
        if (self::$service === null) {
            self::$service = self::create();
        }

        return self::$service;
    }
}
