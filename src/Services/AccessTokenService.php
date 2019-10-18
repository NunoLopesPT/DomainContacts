<?php
namespace NunoLopes\DomainContacts\Services;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\AccessTokenRepository;
use NunoLopes\DomainContacts\Contracts\Services\AuthenticationTokenService;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Services\AccessToken\UserHasNoIdException;
use NunoLopes\DomainContacts\Utilities\RandomGenerator;

/**
 * AccessTokenService Class.
 *
 * This Domain Service will be responsible for all Business Logic related with Access Tokens.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenService
{
    /**
     * @var AccessTokenRepository $accessTokenRepository - AccessToken's Repository instance.
     */
    private $accessTokenRepository = null;

    /**
     * @var AuthenticationTokenService $authTokenService - Authentication Token Service Instance.
     */
    private $authTokenService = null;

    /**
     * AuthenticationService constructor.
     *
     * @param AccessTokenRepository      $accessTokenRepository - AccessToken's Repository instance.
     * @param AuthenticationTokenService $authTokenService      - JWT Service Instance.
     */
    public function __construct(
        AccessTokenRepository $accessTokenRepository,
        AuthenticationTokenService $authTokenService
    ) {
        $this->accessTokenRepository = $accessTokenRepository;
        $this->authTokenService      = $authTokenService;
    }

    /**
     * Creates an Authentication Token.
     *
     * @param User $user - The user that the token will be created for.
     *
     * @throws UserHasNoIdException - If the user has no ID.
     *
     * @return string
     */
    public function createToken(User $user): string
    {
        // Throw exception if the user has no ID.
        if (!$user->hasId()) {
            throw new UserHasNoIdException();
        }

        // Collects current timestamp.
        $stamp = new \DateTime();

        // Creates a new AccessToken to be saved in the persistent layer.
        $accessToken = new AccessToken([
            'token_id'   => RandomGenerator::string(),
            'user_id'    => $user->id(),
            'revoked'    => false,
            'expires_at' => $stamp->add(new \DateInterval("P30D"))->format('Y-m-d H:i:s'),
        ]);

        // Saves the Token ID in the persistent layer.
        $this->accessTokenRepository->create($accessToken);

        // After saving the token in the database, create an authentication token.
        return $this->authTokenService->create($accessToken);
    }

    /**
     * Validates and returns an User from a given AuthenticationToken.
     *
     * @param string $authToken - Authentication Token.
     *
     * @throws \InvalidArgumentException - If the token is empty or invalid.
     *
     * @return AccessToken
     */
    public function getAccessToken(string $authToken): AccessToken
    {
        // Decodes the Token, check its integrity and get the ID of the AccessToken.
        $id = $this->authTokenService->accessTokenId($authToken);

        // Find the token in the database.
        $accessToken = $this->accessTokenRepository->getByToken($id);

        // Return the User instance.
        return $accessToken;
    }

    /**
     * Revokes a token and returns the successful of the operation.
     *
     * @param AccessToken $accessToken - The authentication Access Token.
     *
     * @return bool
     */
    public function revokeToken(AccessToken $accessToken): bool
    {
        return $this->accessTokenRepository->revoke($accessToken);
    }
}
