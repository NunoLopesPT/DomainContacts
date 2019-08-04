<?php
namespace NunoLopes\LaravelContactsAPI\Entities;

use NunoLopes\LaravelContactsAPI\Traits\Entities\AuditTimestampsTrait;

/**
 * AccessTokens Entity.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class AccessToken extends AbstractEntity
{
    use AuditTimestampsTrait;

    /**
     * @var string $token_id - Unique token for authentication.
     */
    protected $token_id = null;

    /**
     * @var int $user_id - ID of the AccessToken User.
     */
    protected $user_id = null;

    /**
     * @var bool $revoked - If the AccessToken is revoked.
     */
    protected $revoked = null;

    /**
     * @var string $created_at - When the token was created.
     */
    protected $created_at = null;

    /**
     * @var string $updated_at - When the token was updated.
     */
    protected $updated_at = null;

    /**
     * @var string $expires_at - When the token will expire.
     */
    protected $expires_at = null;

    /**
     * Returns the id of the Entity.
     *
     * @return string
     */
    public function tokenId(): string
    {
        return $this->token_id;
    }

    /**
     * Set the token_id of the Entity.
     *
     * @param string $token - New token of the entity.
     *
     * @throws \InvalidArgumentException - If the id is not a positive number.
     *
     * @return void
     */
    protected function setTokenId(string $token): void
    {
        if (\strlen(\trim($token)) === 0) {
            throw new \InvalidArgumentException('The token should not be empty');
        }

        $this->token_id = $token;
    }

    /**
     * Set the id of the Entity.
     *
     * @param string $id - Sets the id of the Entity.
     *
     * @throws \InvalidArgumentException - If the id is not a positive number.
     *
     * @return void
     */
    protected function setId($id): void
    {
        if (\strlen(\trim($id)) === 0) {
            throw new \InvalidArgumentException('The id should be a positive number.');
        }

        $this->id = $id;
    }

    /**
     * Returns the ID of the AccessToken User.
     *
     * @return string
     */
    public function userId(): ?string
    {
        return $this->user_id;
    }

    /**
     * Set the ID of the AccessToken's User.
     *
     * @param int $userId - Sets the ID of the AccessToken's User.
     *
     * @throws \InvalidArgumentException - If the user_id is not a positive number.
     *
     * @return void
     */
    protected function setUserId(int $userId): void
    {
        if ($userId < 1) {
            throw new \InvalidArgumentException('The user_id should be a positive number.');
        }

        $this->user_id = $userId;
    }

    /**
     * Returns if the AccessToken is revoked.
     *
     * @return bool
     */
    public function revoked(): bool
    {
        return $this->revoked;
    }

    /**
     * Sets if the AccessToken is revoked.
     *
     * @param bool $revoked - If the AccessToken is revoked.
     *
     * @return void
     */
    protected function setRevoked(bool $revoked): void
    {
        $this->revoked = $revoked;
    }

    /**
     * Returns expiration date in timestamp format.
     *
     * @return int
     */
    public function expiresAt(): int
    {
        return \strtotime($this->expires_at);
    }

    /**
     * Sets the Expiration date.
     *
     * @param string $expiresAt
     */
    protected function setExpiresAt(string $expiresAt)
    {
        $this->expires_at = $expiresAt;
    }
}
