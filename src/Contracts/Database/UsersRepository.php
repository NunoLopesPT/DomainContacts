<?php
namespace NunoLopes\DomainContacts\Contracts\Database;

use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserNotFoundException;

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
     * @param User $user - User entity that will be created.
     *
     * @return int
     */
    public function create(User $user): int;

    /**
     * Retrieves a single User by its ID.
     *
     * @param int $id - ID of the User.
     *
     * @throws \InvalidArgumentException - If the id is not positive.
     * @throws UserNotFoundException     - If the user was not found.
     *
     * @return User
     */
    public function get(int $id): User;

    /**
     * Get User by its email.
     *
     * @param string $email - Email of the User.
     *
     * @throws UserNotFoundException - If the user was not found.
     *
     * @return User
     */
    public function getByEmail(string $email): ?User;
}
