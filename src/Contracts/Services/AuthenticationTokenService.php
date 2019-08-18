<?php

namespace NunoLopes\LaravelContactsAPI\Contracts\Services;

use NunoLopes\LaravelContactsAPI\Entities\AccessToken;

/**
 * Interface AuthenticationTokenService.
 *
 * This contract will allow other AuthenticationTokens to be used with a Strategy Pattern, and
 * making the code more SOLID (Dependency inversion principle).
 *
 * @package NunoLopes\LaravelContactsAPI\Contracts\Services
 */
interface AuthenticationTokenService
{
    /**
     * Create an Authentication Token.
     *
     * @param AccessToken $accessToken - AccessToken that have information to create the authentication token.
     *
     * @return string
     */
    public function create(AccessToken $accessToken): string;

    /**
     * Get the AccessToken ID from an Authentication token.
     *
     * This method will process the token and make sure it is valid.
     *
     * @param string $token - Authentication Token string.
     *
     * @return string
     */
    public function accessTokenId(string $token): string;
}