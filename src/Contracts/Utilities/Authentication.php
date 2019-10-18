<?php
namespace NunoLopes\DomainContacts\Contracts\Utilities;

use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\UserNotAuthenticatedException;

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
     * Returns the accessToken used for authentication.
     *
     * @return AccessToken|null
     */
    public function accessToken(): ?AccessToken;

    /**
     * Returns the authenticated User ID.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     *
     * @return int
     */
    public function id(): int;

    /**
     * Returns the authenticated User.
     *
     * @throws UserNotAuthenticatedException - If the user is not authenticated.
     *
     * @return User
     */
    public function user(): User;

    /**
     * Checks if the user is a guest.
     *
     * @return bool
     */
    public function guest(): bool;
}
