<?php
namespace NunoLopes\Tests\DomainContacts\Integration\Entities;

use NunoLopes\DomainContacts\Eloquent\AccessToken as Model;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserNotFoundException;
use NunoLopes\Tests\DomainContacts\Integration\AbstractIntegrationTest;

/**
 * Class AccessTokenTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenTest extends AbstractIntegrationTest
{
    /**
     * @var Model $model - Eloquent AccessToken Model Instance.
     */
    private $model = null;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Call parent function.
        parent::setUp();

        // Set private class variables.
        $this->model = new Model();
    }

    /**
     * Test can directly retrieve the User of an AccessToken from the database.
     *
     * @return void
     */
    public function testCanRetrieveUser(): void
    {
        // Get random AccessToken from the database.
        $accessToken = new AccessToken($this->model->newQuery()->inRandomOrder()->first()->getAttributes());

        // Get the user from the databsae.
        $user = $accessToken->user();

        // Perform assertions.
        $this->assertInstanceOf(
            User::class,
            $user,
            'The returned instance should have been an User Entity.'
        );
        $this->assertEquals(
            $accessToken->userId(),
            $user->id(),
            'The user IDs should be equal.'
        );
    }

    /**
     * Test that if the AccessToken has an User that doesn't exists an exception is thrown.
     *
     * @return void
     */
    public function testRetrieveUserFailsIfNotFound(): void
    {
        // Creates expectation.
        $this->expectException(UserNotFoundException::class);

        // Create random attributes with an user that doesn't exists.
        $attributes = [
            'id'         => $this->faker->numberBetween(),
            'user_id'    => 2147483647,
            'token_id'   => $this->faker->randomAscii,
            'revoked'    => $this->faker->boolean,
            'expires_at' => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
        ];

        // Creates the AccessToken and performs test.
        $accessToken = new AccessToken($attributes);
        $accessToken->user();
    }
}
