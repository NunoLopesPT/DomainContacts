<?php
namespace NunoLopes\DomainContacts\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Contracts\Database\AccessTokenRepository;
use NunoLopes\DomainContacts\Eloquent\AccessToken as Model;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Exceptions\Repositories\AccessTokens\AccessTokenNotFoundException;

/**
 * Class EloquentAccessTokenRepository.
 */
class EloquentAccessTokenRepository implements AccessTokenRepository
{
    /**
     * @var Model $accessTokens - User's Eloquent model instance.
     */
    protected $accessTokens = null;

    /**
     * Initializes the AccessToken's Repository instance.
     *
     * @param Model $accessToken - AccessToken's Eloquent Model instance.
     */
    public function __construct(Model $accessToken) {
        $this->accessTokens = $accessToken;
    }

    /**
     * @inheritdoc
     * @see AccessTokenRepository::getByToken
     */
    public function getByToken(string $tokenId): AccessToken
    {
        if (\strlen(\trim($tokenId)) === 0) {
            throw new \InvalidArgumentException('The token ID is empty.');
        }

        $accessToken = $this->accessTokens
                            ->newQuery()
                            ->where('token_id', $tokenId)
                            ->first();

        if ($accessToken === null) {
            throw new AccessTokenNotFoundException();
        }

        return new AccessToken($accessToken->getAttributes());
    }

    /**
     * @inheritdoc
     * @todo Handle ForeignKey and Unique token ID exception.
     * @see AccessTokenRepository::create
     */
    public function create(AccessToken $accessToken): AccessToken
    {
        $accessToken = $this->accessTokens
                    ->newQuery()
                    ->create($accessToken->getAttributes());

        return new AccessToken($accessToken->getAttributes());
    }

    /**
     * @inheritdoc
     * @see AccessTokenRepository::revoke
     */
    public function revoke(string $id): bool
    {
        return \boolval(
            $this->accessTokens
                 ->newQuery()
                 ->whereKey($id)
                 ->where('revoked', false)
                 ->update(['revoked' => true])
        );
    }
}
