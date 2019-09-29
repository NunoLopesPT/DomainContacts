<?php
namespace NunoLopes\DomainContacts\Services;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\AccessTokenRepository;
use NunoLopes\DomainContacts\Contracts\Services\AuthenticationTokenService;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Services\AccessToken\UserHasNoIdException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\TokenRevokedException;
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
     * @throws TokenRevokedException - If the token is revoked.
     *
     * @return User
     */
    public function getTokenUser(string $authToken): User
    {
        // Decodes the Token, check its integrity and get the ID of the AccessToken.
        $id = $this->authTokenService->accessTokenId($authToken);

        // Find the token in the database.
        $accessToken = $this->accessTokenRepository->getByToken($id);

        // Check if the token is revoked.
        if ($accessToken->revoked()) {
            throw new TokenRevokedException();
        }

        // Return the User instance.
        return $accessToken->user();
    }

    /**
     * Revokes a token, checking its integrity first.
     *
     * Returns the successful of the operation.
     *
     * @param string $token - The authentication token.
     *
     * @throws \InvalidArgumentException - If the token is empty.
     *
     * @return bool
     */
    public function revokeToken(string $token): bool
    {
        // Decodes the Token, check its integrity and get the ID of the AccessToken.
        $id = $this->authTokenService->accessTokenId($token);

        // Returns the success of the revoke operation.
        return $this->accessTokenRepository->revoke($id);
    }
}
