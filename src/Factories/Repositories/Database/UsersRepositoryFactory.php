<?php
namespace NunoLopes\DomainContacts\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Contracts\Database\UsersRepository;
use NunoLopes\DomainContacts\Eloquent\User;
use NunoLopes\DomainContacts\Repositories\Database\Eloquent\EloquentUsersRepository;

/**
 * Class UsersRepositoryFactory.
 *
 * This class will be used to create an UsersRepository instance.
 *
 * @package NunoLopes\DomainContacts
 */
class UsersRepositoryFactory
{
    /**
     * @var UsersRepository $usersRepository - Singleton instance of UsersRepository.
     */
    private static $usersRepository = null;

    /**
     * Create a new UsersRepository instance.
     *
     * @return UsersRepository
     */
    private static function create(): UsersRepository
    {
        return new EloquentUsersRepository(
            new User()
        );
    }

    /**
     * Get a new UsersRepository instance if not found or
     * return the one already created (Singleton).
     *
     * @return UsersRepository
     */
    public static function get(): UsersRepository
    {
        if (self::$usersRepository === null) {
            self::$usersRepository = self::create();
        }

        return self::$usersRepository;
    }
}
