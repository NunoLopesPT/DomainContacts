<?php
namespace NunoLopes\DomainContacts\Services\AuthenticationToken;

use NunoLopes\DomainContacts\Contracts\Services\AuthenticationTokenService;
use NunoLopes\DomainContacts\Contracts\Utilities\RsaSignature;
use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;
use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;
use NunoLopes\DomainContacts\Entities\AccessToken;

/**
 * This Domain Service will be responsible for all Business Logic
 * related with JSON Web Tokens authentication.
 *
 * @package NunoLopes\DomainContacts\Services
 */
class JwtAuthenticationTokenService implements AuthenticationTokenService
{
    /**
     * @var RsaSignature $signature - Signature instance to use in the JWT.
     */
    private $signature = null;

    /**
     * @var AsymmetricCryptography $crypt - Asymmetric Cryptography instance to digest the JWT.
     */
    private $crypt = null;

    /**
     * JwtAuthenticationTokenService constructor.
     *
     * @param RsaSignature           $signature - Signature instance to use in the JWT.
     * @param AsymmetricCryptography $crypt     - AsymmetricCryptography instance.
     */
    public function __construct(RsaSignature $signature, AsymmetricCryptography $crypt)
    {
        $this->signature = $signature;
        $this->crypt     = $crypt;
    }

    /**
     * Creates a JSON Web Token for authentication.
     *
     * @param AccessToken $accessToken - Access token entity to create the JWT.
     *
     * @todo Compare createdAt and expiresAt to check if is valid.
     *
     * @return string
     */
    public function create(AccessToken $accessToken): string
    {
        $jwt = new JsonWebToken();

        // Creates the payload based on the token.
        $jwt->payload()
            ->id($accessToken->tokenId())
            ->issuedAt(\strtotime($accessToken->createdAt()))
            ->expiration(\strtotime($accessToken->expiresAt()));

        // Sign the token with the class's Signature.
        $jwt->sign($this->signature, $this->crypt);

        // Return the created JWT Token encoded.
        return 'Bearer ' . $jwt->encode();
    }

    /**
     * Decodes the JSON Web Token, check its integrity and get the ID of the token.
     *
     * @param string $token - JSON Web Token.
     *
     * @return string
     */
    public function accessTokenId(string $token): string
    {
        $jwt = new JsonWebToken();

        // Decodes the token into a readable and documented datatype.
        $jwt->decode($token);

        // Check if the token is valid and was not changed by using a public key.
        $jwt->verify($this->signature,  $this->crypt);

        // If the token had no problems in the verification, get the ID since the token was not changed.
        return $jwt->payload()->getId();
    }
}
