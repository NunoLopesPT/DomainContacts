<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Entities;

use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Exceptions\Entities\RequiredAttributeMissingException;

/**
 * Class AccessTokenTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenTest extends AbstractEntityTest
{
    /**
     * Test that an AccessToken entity can be created with an ID.
     *
     * @return void
     */
    public function testAccessTokenCanBeCreated(): void
    {
        // Create random attributes.
        $attributes = [
            'id'         => $this->faker->numberBetween(),
            'user_id'    => $this->faker->numberBetween(),
            'token_id'   => $this->faker->randomAscii,
            'revoked'    => $this->faker->boolean,
            'expires_at' => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
        ];

        // Performs test.
        $contact = new AccessToken($attributes);

        // Performs assertions.
        $this->assertTrue(
            $contact->hasId(),
            'The contact should have an ID'
        );
        $this->validateEntityAttributes(
            $contact,
            $attributes
        );
    }

    /**
     * Test that a Contact entity can be created without ID.
     *
     * @return void
     */
    public function testContactCanBeCreatedWithoutId(): void
    {
        // Create random attributes.
        $attributes = [
            'user_id'    => $this->faker->numberBetween(),
            'token_id'   => $this->faker->randomAscii,
            'revoked'    => $this->faker->boolean,
            'expires_at' => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
        ];

        // Performs test.
        $contact = new AccessToken($attributes);

        // Performs assertions.
        $this->assertFalse(
            $contact->hasId(),
            'The contact should not have an ID'
        );
        $this->validateEntityAttributes(
            $contact,
            $attributes
        );
    }

    /**
     * Test that creating an AccessToken entity without the required user id fails.
     *
     * @return void
     */
    public function testAccessTokenCreationFailsIfRequiredUserIdIsMissing(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        // Create random attributes.
        $attributes = [
            'token_id'   => $this->faker->randomAscii,
            'revoked'    => $this->faker->boolean,
            'expires_at' => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
        ];

        // Performs test.
        new AccessToken($attributes);
    }

    /**
     * Test that creating an AccessToken entity without the required Token ID fails.
     *
     * @return void
     */
    public function testAccessTokenCreationFailsIfRequiredTokenIdIsMissing(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        // Create random attributes.
        $attributes = [
            'user_id'    => $this->faker->numberBetween(),
            'revoked'    => $this->faker->boolean,
            'expires_at' => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
        ];

        // Performs test.
        new AccessToken($attributes);
    }

    /**
     * Test that creating an AccessToken entity with a negative id fails.
     *
     * @return void
     */
    public function testCreatingAccessTokenWithNegativeIdFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'id'         => -1,
            'user_id'    => $this->faker->numberBetween(),
            'token_id'   => $this->faker->randomAscii,
            'revoked'    => $this->faker->boolean,
            'expires_at' => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
        ];

        // Performs test.
        new AccessToken($attributes);
    }

    /**
     * Test that creating an AccessToken entity with a negative User Id fails.
     *
     * @return void
     */
    public function testCreatingContactWithNegativeUserIdFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'id'         => $this->faker->numberBetween(),
            'user_id'    => -1,
            'token_id'   => $this->faker->randomAscii,
            'revoked'    => $this->faker->boolean,
            'expires_at' => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
        ];

        // Performs test.
        new AccessToken($attributes);
    }

    /**
     * Test that creating an AccessToken entity with an empty token ID fails.
     *
     * @return void
     */
    public function testCreatingContactWithEmptyTokenIdFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'user_id'    => $this->faker->numberBetween(),
            'token_id'   => '       ',
            'revoked'    => $this->faker->boolean,
            'expires_at' => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
        ];

        // Performs test.
        new AccessToken($attributes);
    }
}
