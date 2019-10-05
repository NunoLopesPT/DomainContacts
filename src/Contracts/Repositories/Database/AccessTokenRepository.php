<?php
namespace NunoLopes\DomainContacts\Contracts\Repositories\Database;

use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Exceptions\Repositories\AccessTokens\AccessTokenAlreadyCreatedException;

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
     * @param string $token - AccessToken ID.
     *
     * @return AccessToken
     */
    public function getByToken(string $token): AccessToken;

    /**
     * Will create a new AccessToken in the persistence layer, returning
     * the created Entity with an ID.
     *
     * @param AccessToken $accessToken - AccessToken that will be created.
     *
     * @throws AccessTokenAlreadyCreatedException - If the AccessToken is already created.
     *
     * @return AccessToken
     */
    public function create(AccessToken $accessToken): AccessToken;

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
