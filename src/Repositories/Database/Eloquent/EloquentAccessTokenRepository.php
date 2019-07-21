<?php
namespace NunoLopes\LaravelContactsAPI\Repositories\Database\Eloquent;

use NunoLopes\LaravelContactsAPI\Contracts\Database\AccessTokenRepository;
use NunoLopes\LaravelContactsAPI\Eloquent\AccessToken as Model;
use NunoLopes\LaravelContactsAPI\Entities\AccessToken;
use NunoLopes\LaravelContactsAPI\Entities\User;

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
     * @see AccessTokenRepository::findByUser
     */
    public function findByUser(User $user): ?AccessToken
    {
        $accessToken = $this->accessTokens
                            ->newQuery()
                            ->where([
                                'user_id' => $user->id(),
                                'revoked' => false,
                            ])
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
