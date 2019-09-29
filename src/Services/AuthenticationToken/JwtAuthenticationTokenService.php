<?php

namespace NunoLopes\DomainContacts\Services\AuthenticationToken;

use NunoLopes\DomainContacts\Contracts\Services\AuthenticationTokenService;
use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Utilities\Signatures\RsaSignature;

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
     * JwtAuthenticationTokenService constructor.
     *
     * @param RsaSignature $signature - Signature instance to use in the JWT.
     */
    public function __construct(RsaSignature $signature)
    {
        $this->signature = $signature;
    }

    /**
     * Creates a JSON Web Token for authentication.
     *
     * @param AccessToken $accessToken - Access token entity to create the JWT.
     *
     * @return string
     */
    public function create(AccessToken $accessToken): string
    {
        $jwt = new JsonWebToken();

        // Creates the header and the payload based on the token.
        $jwt->header()
            ->type("JWT")
            ->algorithm("RS256");
        $jwt->payload()
            ->id($accessToken->tokenId())
            ->issuedAt($accessToken->createdAt())
            ->expiration($accessToken->expiresAt());

        // Sign the token with the class's Signature.
        $jwt->sign($this->signature);

        // Return the created JWT Token.
        return $jwt->encode();
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
        $jwt->verify($this->signature);

        // If the token had no problems in the verification, get the ID since the token was not changed.
        return $jwt->payload()->get('jti');
    }
}
