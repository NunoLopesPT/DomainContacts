<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Entities;

use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Entities\RequiredAttributeMissingException;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class UserTest.
 *
 * @package NunoLopes\DomainContacts
 */
class UserTest extends AbstractTest
{
    /**
     * Test that an user entity can be created.
     */
    public function testUserCanBeCreatedWithId(): void
    {
        // Create random attributes.
        $attributes = [
            'id'       => 2,
            'name'     => $this->faker->userName,
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];

        // Performs test.
        $user = new User($attributes);

        // Performs assertions.
        $this->assertEquals(
            $attributes['id'],
            $user->id(),
            'The ids should be equal'
        );
        $this->assertTrue(
            $user->hasId(),
            'The user shouldn\'t have an ID'
        );
        $this->assertEquals(
            $attributes['name'],
            $user->name(),
            'The names should be equal.'
        );
        $this->assertEquals(
            $attributes['email'],
            $user->email(),
            'The emails should be equal.'
        );
        $this->assertEquals(
            $attributes['password'],
            $user->password(),
            'The passwords should be equal.'
        );
        $this->assertEmpty(
            $user->getDirtyAttributes(),
            'The dirty attributes should be empty'
        );

        // Get the Entity Attributes.
        $userAttributes = $user->getAttributes();

        // Assert finally all set attributes.
        foreach ($attributes as $attribute => $value) {
            $this->assertEquals(
                $userAttributes[$attribute],
                $value,
                "The $attribute is not the same."
            );
        }
    }

    /**
     * Test that an user entity can be created.
     */
    public function testUserCanBeCreatedWithoutId(): void
    {
        // Create random attributes.
        $attributes = [
            'name'     => $this->faker->userName,
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];

        // Performs test.
        $user = new User($attributes);

        // Performs assertions.
        $this->assertNull(
            $user->id(),
            'The id should be null'
        );
        $this->assertFalse(
            $user->hasId(),
            'The user shouldn\'t have an ID'
        );
    }
    /**
     * Test that creating an User entity without the required name fails.
     *
     * @return void
     */
    public function testUserCreationFailsIfRequiredNameIsMissing(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        // Create random attributes.
        $attributes = [
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];

        // Performs test.
        new User($attributes);
    }

    /**
     * Test that creating an User entity without the required email fails.
     *
     * @return void
     */
    public function testUserCreationFailsIfRequiredEmailIsMissing(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        // Create random attributes.
        $attributes = [
            'name'     => $this->faker->userName,
            'password' => $this->faker->password,
        ];

        // Performs test.
        new User($attributes);
    }

    /**
     * Test that creating an User entity without the required password fails.
     *
     * @return void
     */
    public function testUserCreationFailsIfRequiredPasswordIsMissing(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        // Create random attributes.
        $attributes = [
            'name'     => $this->faker->userName,
            'email'    => $this->faker->email,
        ];

        // Performs test.
        new User($attributes);
    }

    /**
     * Test that creating an User entity with a negative id fails.
     *
     * @return void
     */
    public function testCreatingUserWithNegativeIdFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'id'       => -1,
            'name'     => $this->faker->userName,
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];

        // Performs test.
        new User($attributes);
    }

    /**
     * Test that creating an User entity with an empty name fails.
     *
     * @return void
     */
    public function testCreatingUserWithEmptyNameFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'name'     => '      ',
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];

        // Performs test.
        new User($attributes);
    }

    /**
     * Test that creating an User entity with an empty email fails.
     *
     * @return void
     */
    public function testCreatingUserWithEmptyEmailFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'name'     => $this->faker->name,
            'email'    => '      ',
            'password' => $this->faker->password,
        ];

        // Performs test.
        new User($attributes);
    }

    /**
     * Test that creating an User entity with an empty password fails.
     *
     * @return void
     */
    public function testCreatingUserWithEmptyPasswordFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'name'     => $this->faker->name,
            'email'    => $this->faker->email,
            'password' => '      ',
        ];

        // Performs test.
        new User($attributes);
    }

    /**
     * Test that the whitespaces should be clean from the end and start of the name and email.
     *
     * @return void
     */
    public function testWhiteCharactersAreCleanedWhenCreatingUser(): void
    {
        $attributes = [
            'name'     => $this->faker->name  . '     ',
            'email'    => $this->faker->email . '     ',
            'password' => $this->faker->password . '   ',
        ];

        // Performs test.
        $user = new User($attributes);

        // Performs assertion.
        $this->assertEquals(
            \trim($attributes['name']),
            $user->name(),
            'The white spaces were not cleared.'
        );
        $this->assertEquals(
            \trim($attributes['email']),
            $user->email(),
            'The white spaces were not cleared.'
        );
        $this->assertEquals(
            $attributes['password'],
            $user->password(),
            'The white spaces from the password shouldn\'t be cleared.'
        );
    }
}
