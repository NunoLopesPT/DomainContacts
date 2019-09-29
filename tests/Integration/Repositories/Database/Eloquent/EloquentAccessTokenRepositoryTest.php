<?php
namespace NunoLopes\Tests\DomainContacts\Integration\Repositories\Database\Eloquent;

use Illuminate\Database\QueryException;
use NunoLopes\DomainContacts\Eloquent\AccessToken as Model;
use NunoLopes\DomainContacts\Eloquent\User;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Exceptions\Repositories\AccessTokens\AccessTokenNotFoundException;
use NunoLopes\DomainContacts\Repositories\Database\Eloquent\EloquentAccessTokenRepository;
use NunoLopes\Tests\DomainContacts\Integration\AbstractIntegrationTest;

/**
 * Class EloquentAccessTokenRepositoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class EloquentAccessTokenRepositoryTest extends AbstractIntegrationTest
{
    /**
     * @var EloquentAccessTokenRepository $repository - Eloquent AccessToken Repository Instance.
     */
    private $repository = null;

    /**
     * @var Model $model - Eloquent AccessToken Model Instance.
     */
    private $model = null;

    /**
     * @var User $user - Eloquent Users Model Instance.
     */
    private $user = null;

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function setUp(): void
    {
        // Call parent function.
        parent::setUp();

        // Calls dependencies.
        $this->user       = new User();
        $this->model      = new Model();
        $this->repository = new EloquentAccessTokenRepository($this->model);
    }

    /**
     * Test if a user can be created and the creation ID is returned.
     *
     * @return void
     */
    public function testAccessTokenCanBeCreated(): void
    {
        // Get a random User.
        $user = $this->user
                     ->newQuery()
                     ->inRandomOrder()
                     ->first();

        // Attributes of the AccessToken.
        $attributes = [
            'token_id'     => $this->faker->randomAscii,
            'user_id'      => $user->id,
            'expires_at'   => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s')
        ];

        // AccessToken Entity with the created attributes.
        $accessToken = new AccessToken($attributes);

        // Perform test.
        $createdAccessToken = $this->repository->create($accessToken);

        // Perform assertions.
        $this->assertSame(
            $accessToken,
            $createdAccessToken,
            'The instances should be the same.'
        );
        $this->assertInstanceOf(
            AccessToken::class,
            $accessToken,
            'The creation should have returned an AccessToken Entity.'
        );
        $this->assertTrue(
            $accessToken->hasId(),
            'The creation of AccessToken should have an ID.'
        );
        $this->assertNotNull(
            $accessToken->createdAt(),
            'The created at should not be null.'
        );
    }

    /**
     * Test if an access token is created with an user that doesn't exists, an exception is thrown.
     *
     * @return void
     */
    public function testAccessTokenCannotBeCreatedWithInexistentUser(): void
    {
        // Creates expectation.
        $this->expectException(QueryException::class);

        // Perform test.
        $this->repository->create(
            new AccessToken([
                'token_id'     => $this->faker->randomAscii,
                'user_id'      => 2147483647,
                'expires_at'   => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s')
            ])
        );
    }

    /**
     * Test if an access token is created with an user that doesn't exists, an exception is thrown.
     *
     * @return void
     */
    public function testAccessTokenCannotBeCreatedWithAnExistentToken(): void
    {
        // Creates expectation.
        $this->expectException(QueryException::class);

        // Get a random AccessToken.
        $accessToken = $this->model->newQuery()->inRandomOrder()->first();

        // Perform test.
        $this->repository->create(
            new AccessToken([
                'token_id'     => $accessToken->token_id,
                'user_id'      => $accessToken->user_id,
                'expires_at'   => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s')
            ])
        );
    }

    /**
     * Tests that if we try to get an AccessToken with an empty string, an exception is thrown.
     *
     * @return void
     */
    public function testGetByTokenFailsWithEmptyTokenId(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        $this->repository->getByToken('');
    }

    /**
     * Tests that if we try to get an AccessToken with an empty string, an exception is thrown.
     *
     * @return void
     */
    public function testGetByTokenFailsIfDoesntExist(): void
    {
        // Creates expectation.
        $this->expectException(AccessTokenNotFoundException::class);

        // Performs test.
        $this->repository->getByToken('DummyTokenIdThatDoesntExistsInTheDatabase');
    }

    /**
     * Test that an AccessToken can be get by its token_id.
     *
     * @return void
     */
    public function testAccessTokenCanBeGetByTokenId(): void
    {
        // Collects a random AccessToken.
        $model = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first();

        // Get the AccessToken from the Repository.
        $accessToken = $this->repository->getByToken($model->token_id);

        // Perform assertions
        $this->assertInstanceOf(
            AccessToken::class,
            $accessToken,
            'The instance should be an AccessToken entity.'
        );
        $this->assertEquals(
            $accessToken->id(),
            $model->id,
            'The ids should be equal.'
        );
        $this->assertEquals(
            $accessToken->tokenId(),
            $model->token_id,
            'The token IDs should be equal.'
        );
        $this->assertEquals(
            $accessToken->userId(),
            $model->user_id,
            'The last names should be equal.'
        );
        $this->assertEquals(
            $accessToken->revoked(),
            $model->revoked,
            'The revoked flag should be equal.'
        );
    }

    /**
     * Test revoking an AccessToken not revoked.
     *
     * @return void
     */
    public function testAccessTokenCanBeRevoked(): void
    {
        // Collects a random User.
        $model = $this->model
            ->newQuery()
            ->where('revoked', false)
            ->inRandomOrder()
            ->first();

        // Performs test.
        $result = $this->repository->revoke($model->id);

        // Performs assertion.
        $this->assertTrue(
            $result,
            'The revoke operation should have returned true'
        );
    }

    /**
     * Test revoke an AccessToken already revoked.
     *
     * @return void
     */
    public function testAccessTokenAlreadyRevokedReturnsFalse(): void
    {
        // Collects a random User.
        $model = $this->model
            ->newQuery()
            ->where('revoked', true)
            ->inRandomOrder()
            ->first();

        // Performs test.
        $result = $this->repository->revoke($model->id);

        // Performs assertion.
        $this->assertFalse(
            $result,
            'The revoke operation should have returned true'
        );
    }
}
