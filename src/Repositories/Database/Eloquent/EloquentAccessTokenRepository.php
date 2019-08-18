<?php
namespace NunoLopes\DomainContacts\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Contracts\Database\AccessTokenRepository;
use NunoLopes\DomainContacts\Eloquent\AccessToken as Model;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Entities\User;

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
     * @see AccessTokenRepository::findByToken
     */
    public function findByToken(string $tokenId): ?AccessToken
    {
        $accessToken = $this->accessTokens
                            ->newQuery()
                            ->where('token_id', $tokenId)
                            ->first();

        return new AccessToken($accessToken->getAttributes());
    }

    /**
     * @inheritdoc
     * @see AccessTokenRepository::create
     */
    public function create(AccessToken $accessToken): int
    {
        $accessToken = $this->accessTokens
                    ->newQuery()
                    ->create($accessToken->getAttributes());

        // ID é sempre 0.
        return $accessToken->id;
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
                    ->update(['revoked' => true])
        );
    }
}
