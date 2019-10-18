<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\Contacts\CreateContactRequest;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class CreateContactRequestTest.
 *
 * @package NunoLopes\DomainContacts
 */
class CreateContactRequestTest extends AbstractTest
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
     * Test CreateContactRequest fails if there is no first_name.
     *
     * @return void
     */
    public function testCreateContactRequestFailsIfNoFirstNameIsPresent(): void
    {
        // Unsets required variable to test request.
        unset($_POST['first_name']);

        // Performs test.
        $request = new CreateContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test CreateContactRequest fails if first name is too short.
     *
     * @return void
     */
    public function testCreateContactRequestFailsIfFirstNameIsTooShort(): void
    {
        // Change Attribute.
        $_POST['first_name'] = 'a';

        // Performs test.
        $request = new CreateContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test CreateContactRequest fails if email is invalid.
     *
     * @return void
     */
    public function testCreateContactRequestFailsIfEmailIsInvalid(): void
    {
        // Change Attribute.
        $_POST['email'] = 'invalidemail.com';

        // Performs test.
        $request = new CreateContactRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test CreateContactRequest succeeds.
     *
     * @return void
     */
    public function testCreateContactRequestSucceeds(): void
    {
        // Performs test.
        $request = new CreateContactRequest();

        // Performs assertion.
        $this->assertFalse($request->fails());
    }
}
