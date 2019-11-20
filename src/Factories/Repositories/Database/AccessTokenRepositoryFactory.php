<?php
namespace NunoLopes\DomainContacts\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\AccessTokenRepository;
use NunoLopes\DomainContacts\Eloquent\AccessToken;
use NunoLopes\DomainContacts\Repositories\Database\Eloquent\EloquentAccessTokenRepository;

/**
 * Class AccessTokenRepositoryFactory.
 *
 * This class will be used to create an AccessTokenRepository instance.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenRepositoryFactory
{
    /**
     * @var EloquentAccessTokenRepository $repository - Singleton instance of AccessTokenRepository.
     */
    private static $usersRepository = null;

    /**
     * Create a new EloquentAccessTokenRepository instance.
     *
     * @return EloquentAccessTokenRepository
     */
    private static function create(): AccessTokenRepository
    {
        return new EloquentAccessTokenRepository(
            new AccessToken()
        );
    }

    /**
     * Get a new EloquentAccessTokenRepository instance if not found or
     * return the one already created (Singleton).
     *
     * @return EloquentAccessTokenRepository
     */
    public static function get(): EloquentAccessTokenRepository
    {
        if (self::$usersRepository === null) {
            self::$usersRepository = self::create();
        }

        return self::$usersRepository;
    }
}
