<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Entities;

use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Exceptions\Entities\RequiredAttributeMissingException;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class ContactTest.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactTest extends AbstractTest
{
    /**
     * Test that a Contact entity can be created.
     */
    public function testContactCanBeCreatedWithId(): void
    {
        // Create random attributes.
        $attributes = [
            'id'           => $this->faker->numberBetween(),
            'user_id'      => $this->faker->numberBetween(),
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
        ];

        // Performs test.
        $contact = new Contact($attributes);

        // Performs assertions.
        $this->assertEquals(
            $attributes['id'],
            $contact->id(),
            'The ids should be equal'
        );
        $this->assertTrue(
            $contact->hasId(),
            'The contact should have an ID'
        );
        $this->assertEquals(
            $attributes['user_id'],
            $contact->userId(),
            'The User ID should be the same.'
        );
        $this->assertEquals(
            $attributes['first_name'],
            $contact->firstName(),
            'The first names should be equal.'
        );
        $this->assertEquals(
            $attributes['last_name'],
            $contact->lastName(),
            'The last names should be equal.'
        );
        $this->assertEquals(
            $attributes['email'],
            $contact->email(),
            'The emails should be equal.'
        );
        $this->assertEquals(
            $attributes['phone_number'],
            $contact->phoneNumber(),
            'The phone numbers should be equal.'
        );
        $this->assertEmpty(
            $contact->getDirtyAttributes(),
            'The dirty attributes should be empty'
        );

        // Get the Entity Attributes.
        $contactAttributes = $contact->getAttributes();

        // Assert finally all set attributes.
        foreach ($attributes as $attribute => $value) {
            $this->assertEquals(
                $contactAttributes[$attribute],
                $value,
                "The $attribute is not the same."
            );
        }
    }

    /**
     * Test that a Contact entity can be created.
     */
    public function testContactCanBeCreatedWithoutId(): void
    {
        // Create random attributes.
        $attributes = [
            'user_id'      => $this->faker->numberBetween(),
            'first_name'   => $this->faker->firstName,
            'last_name'    => '    ',
            'phone_number' => '    ',
            'email'        => '    ',
        ];

        // Performs test.
        $contact = new Contact($attributes);

        // Performs assertions.
        $this->assertNull(
            $contact->id(),
            'The id should be null.'
        );
        $this->assertFalse(
            $contact->hasId(),
            'The user shouldn\'t have an ID.'
        );
        $this->assertNull(
            $contact->lastName(),
            'The last name should be null.'
        );
        $this->assertNull(
            $contact->email(),
            'The email should be null.'
        );
        $this->assertNull(
            $contact->phoneNumber(),
            'The phone number should be null.'
        );
    }

    /**
     * Test that creating a Contact entity without the required first_name fails.
     *
     * @return void
     */
    public function testContactCreationFailsIfRequiredFirstNameIsMissing(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        // Create random attributes.
        $attributes = [
            'user_id'      => $this->faker->numberBetween(),
            'last_name'    => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
        ];

        // Performs test.
        new Contact($attributes);
    }

    /**
     * Test that creating a Contact entity without the required User ID fails.
     *
     * @return void
     */
    public function testContactCreationFailsIfRequiredUserIdIsMissing(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        // Create random attributes.
        $attributes = [
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
        ];

        // Performs test.
        new Contact($attributes);
    }

    /**
     * Test that creating a Contact entity with a negative id fails.
     *
     * @return void
     */
    public function testCreatingContactWithNegativeIdFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'id'       => -1,
            'user_id'      => $this->faker->numberBetween(),
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
        ];

        // Performs test.
        new Contact($attributes);
    }

    /**
     * Test that creating a Contact entity with a negative User Id fails.
     *
     * @return void
     */
    public function testCreatingContactWithNegativeUserIdFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'id'           => $this->faker->numberBetween(),
            'user_id'      => -1,
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
        ];

        // Performs test.
        new Contact($attributes);
    }

    /**
     * Test that creating a Contact entity with a neutral User Id fails.
     *
     * @return void
     */
    public function testCreatingContactWithNeutralUserIdFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'id'           => $this->faker->numberBetween(),
            'user_id'      => 0,
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
        ];

        // Performs test.
        new Contact($attributes);
    }

    /**
     * Test that creating a Contact entity with an empty first name fails.
     *
     * @return void
     */
    public function testCreatingContactWithEmptyFirstNameFails(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Create random attributes.
        $attributes = [
            'user_id'      => $this->faker->numberBetween(),
            'first_name'   => '       ',
            'last_name'    => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
        ];

        // Performs test.
        new Contact($attributes);
    }

    /**
     * Test that the whitespaces should be clean from the end and start of the name and email.
     *
     * @return void
     */
    public function testWhiteCharactersAreCleanedWhenCreatingUser(): void
    {
        $attributes = [
            'user_id'      => $this->faker->numberBetween(),
            'first_name'   => $this->faker->firstName   . '      ',
            'last_name'    => $this->faker->lastName    . '      ',
            'phone_number' => $this->faker->phoneNumber . '      ',
            'email'        => $this->faker->email       . '      ',
        ];

        // Performs test.
        $user = new Contact($attributes);

        // Performs assertion.
        $this->assertEquals(
            \trim($attributes['first_name']),
            $user->firstName(),
            'The white spaces were not cleared.'
        );
        $this->assertEquals(
            \trim($attributes['last_name']),
            $user->lastName(),
            'The white spaces were not cleared.'
        );
        $this->assertEquals(
            \trim($attributes['email']),
            $user->email(),
            'The white spaces were not cleared.'
        );
        $this->assertEquals(
            \trim($attributes['phone_number']),
            $user->phoneNumber(),
            'The white spaces were not cleared.'
        );
    }
}
