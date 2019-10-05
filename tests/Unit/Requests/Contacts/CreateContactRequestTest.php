<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\Contacts\CreateContactRequest;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class LoginUserRequestTest.
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
     * Test LoginUserRequest fails if there is no password.
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
}