<?php
namespace NunoLopes\LaravelContactsAPI\Contracts\Database;

use NunoLopes\LaravelContactsAPI\Entities\AccessToken;
use NunoLopes\LaravelContactsAPI\Entities\User;

/**
 * AccessToken Repository Contract.
 *
 * This contract will allow other repositories to be used with a Strategy Pattern, and
 * making the code more SOLID (Dependency inversion principle).
 *
 * All AccessToken Repository will implement this Contract.
 */
interface AccessTokenRepository
{
    /**
     * Retrieves a single AccessToken by its User.
     *
     * @param User $user - User's Entity.
     *
     * @return AccessToken
     */
    public function findByUser(User $user): ?AccessToken;

    /**
     * Creates an AccessToken.
     *
     * Returns the AccessToken ID.
     *
     * @param AccessToken $accessToken - AccessToken that will be created.
     *
     * @return int
     */
    public function create(AccessToken $accessToken): int;

    /**
     * Revokes an AccessToken.
     *
     * Returns operation success.
     *
     * @param string $id - ID of the AccessToken.
     *
     * @return bool
     */
    public function revoke(string $id): bool;
}
