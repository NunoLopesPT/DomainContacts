<?php

namespace NunoLopes\DomainContacts\Services\AuthenticationToken;

use NunoLopes\DomainContacts\Contracts\Services\AuthenticationTokenService;
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
     * @var JsonWebToken $token - JSON Web Token instance.
     */
    protected $token = null;

    /**
     * JwtAuthenticationTokenService constructor.
     *
     * @param JsonWebToken $token - JSON Web Token instance.
     *
     * @todo Add a factory that will create a token so this isn't a dependency
     * Services don't have state.
     */
    public function __construct(JsonWebToken $token)
    {
        $this->token = $token;
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
        // Creates the header and the payload based on the token.
        $this->token->header()
                    ->type("JWT")
                    ->algorithm("RS256");
        $this->token->payload()
                    ->id($accessToken->tokenId())
                    ->issuedAt($accessToken->createdAt())
                    ->expiration($accessToken->expiresAt());

        // Sign the token with the private key.
        $this->token->sign();

        // Return the created JWT Token.
        return $this->token->encode();
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
        // Decodes the token into a readable and documented datatype.
        $this->token->decode($token);

        // Check if the token is valid and was not changed by using a public key.
        $this->token->verify();

        // If the token had no problems in the verification, get the ID since the token was not changed.
        return $this->token->payload()->get('jti');
    }
}
