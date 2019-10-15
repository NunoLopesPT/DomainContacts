<?php
namespace NunoLopes\DomainContacts\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\AccessTokenRepository;
use NunoLopes\DomainContacts\Eloquent\AccessToken as Model;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Exceptions\Repositories\AccessTokens\AccessTokenAlreadyCreatedException;
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
     *
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
     *
     * @todo Handle ForeignKey and Unique token ID exception.
     *
     * @see AccessTokenRepository::create
     */
    public function create(AccessToken $accessToken): AccessToken
    {
        // Throw exception if the user already has an ID.
        if ($accessToken->hasId()) {
            throw new AccessTokenAlreadyCreatedException();
        }

        // Create the AccessToken in the database.
        $model = $this->accessTokens
                    ->newQuery()
                    ->create($accessToken->getAttributes());

        // Set the new attributes in the original Entity.
        $accessToken->setAttributes($model->getAttributes());

        // Return the same instance with updated attributes.
        return $accessToken;
    }

    /**
     * @inheritdoc
     *
     * @see AccessTokenRepository::revoke
     */
    public function revoke(AccessToken $accessToken): bool
    {
        // If the AccessToken is already revoked, no need to query the database.
        if ($accessToken->revoked()) {
            return false;
        }

        // Revoke the AccessToken.
        return \boolval(
            $this->accessTokens
                 ->newQuery()
                 ->whereKey($accessToken->id())
                 ->update(['revoked' => true])
        );
    }
}
