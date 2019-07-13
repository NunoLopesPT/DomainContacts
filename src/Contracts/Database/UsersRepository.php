<?php
namespace NunoLopes\LaravelContactsAPI\Contracts\Database;

use NunoLopes\LaravelContactsAPI\Entities\User;

/**
 * Users Repository Contract.
 *
 * This contract will allow other repositories to be used with a Strategy Pattern, and
 * making the code more SOLID (Dependency inversion principle).
 *
 * All Users Repository will implement this Contract.
 */
interface UsersRepository
{
    /**
     * Will create a new User in the persistence layer, returning its ID.
     *
     * @param array $attributes - Attributes of the User that will be created.
     *
     * @return int
     */
    public function create(array $attributes): int;

    /**
     * Retrieves a single User by its ID.
     *
     * @param int $id - ID of the User.
     *
     * @return User
     */
    public function get(int $id): ?User;
}
