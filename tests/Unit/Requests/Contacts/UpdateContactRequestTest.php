<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\Contacts\UpdateContactRequest;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class UpdateContactRequestTest.
 *
 * @package NunoLopes\DomainContacts
 */
class UpdateContactRequestTest extends AbstractTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent class.
        parent::setUp();

        // Fills POST variable so the Request catches it.
        $_POST = [
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'email'        => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
        ];
    }

    /**
     * Test UpdateContactRequest fails if there is no first_name.
     *
     * @return void
     */
    public function testUpdateContactRequestFailsIfNoFirstNameIsPresent(): void
    {
        // Unsets required variable to test request.
        unset($_POST['first_name']);

        // Performs test.
        $request = new UpdateContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test UpdateContactRequest fails if first name is too short.
     *
     * @return void
     */
    public function testUpdateContactRequestFailsIfFirstNameIsTooShort(): void
    {
        // Change Attribute.
        $_POST['first_name'] = 'a';

        // Performs test.
        $request = new UpdateContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test UpdateContactRequest fails if email is invalid.
     *
     * @return void
     */
    public function testUpdateContactRequestFailsIfEmailIsInvalid(): void
    {
        // Change Attribute.
        $_POST['email'] = 'invalidemail.com';

        // Performs test.
        $request = new UpdateContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test UpdateContactRequest succeeds.
     *
     * @return void
     */
    public function testUpdateContactRequestSucceeds(): void
    {
        // Performs test.
        $request = new UpdateContactRequest();

        // Performs assertion.
        $this->assertFalse($request->fails());
    }
}
