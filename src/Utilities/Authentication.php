<?php
namespace NunoLopes\DomainContacts\Utilities;

use NunoLopes\DomainContacts\Contracts\Utilities\Authentication as Contract;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\UserNotAuthenticatedException;

/**
 * Class LaravelAuthentication
 *
 * @todo move to datatype
 *
 * @package NunoLopes\DomainContacts
 */
class Authentication implements Contract
{
    /**
     * @var null|AccessToken $accessToken - LoggedIn User's Entity.
     */
    private $accessToken = null;

    /**
     * LaravelAuthentication constructor.
     *
     * @param AccessToken $accessToken - AccessToken of the authenticated user.
     */
    public function __construct(AccessToken $accessToken = null)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @inheritdoc
     */
    public function accessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @inheritdoc
     */
    public function id(): int
    {
        if ($this->guest()) {
            throw new UserNotAuthenticatedException();
        }

        return $this->accessToken->userId();
    }

    /**
     * @inheritdoc
     */
    public function user(): User
    {
        if ($this->guest()) {
            throw new UserNotAuthenticatedException();
        }

        return $this->accessToken->user();
    }

    /**
     * @inheritdoc
     */
    public function guest(): bool
    {
        return $this->accessToken === null;
    }
}
