<?php
namespace NunoLopes\DomainContacts\Contracts\Utilities;

use NunoLopes\DomainContacts\Entities\User;

/**
 * Authentication Contract.
 *
 * This contract will allow other Authentication to be used with a Strategy Pattern, and
 * making the code more SOLID (Dependency inversion principle).
 *
 * All Authentications Utilities will implement this Contract.
 */
interface Authentication
{
    /**
     * Returns the authenticated User ID.
     *
     * @return int
     */
    public function id(): int;

    /**
     * Returns the authenticated User.
     *
     * @return User|null
     */
    public function user(): ?User;

    /**
     * Checks if the user is a guest.
     *
     * @return bool
     */
    public function guest(): bool;
}
