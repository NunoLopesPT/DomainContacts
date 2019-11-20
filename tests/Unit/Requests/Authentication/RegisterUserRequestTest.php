<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\Authentication\RegisterUserRequest;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class LoginUserRequestTest.
 *
 * @package NunoLopes\DomainContacts
 */
class RegisterUserRequestTest extends AbstractTest
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
            'name'     => $this->faker->name,
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];
    }

    /**
     * Test LoginUserRequest fails if there is no password.
     *
     * @return void
     */
    public function testLoginUserRequestFailsIfNoPasswordIsPresent(): void
    {
        // Unsets required variable to test request.
        unset($_POST['password']);

        // Performs test.
        $request = new RegisterUserRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test LoginUserRequest fails if there is no password.
     *
     * @return void
     */
    public function testLoginUserRequestFailsIfNoNameIsPresent(): void
    {
        // Unsets required variable to test request.
        unset($_POST['name']);

        // Performs test.
        $request = new RegisterUserRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test RegisterUserRequest succeeds.
     *
     * @return void
     */
    public function testRegisterUserRequestSucceeds(): void
    {
        // Performs test.
        $request = new RegisterUserRequest();

        // Performs assertions.
        $this->assertFalse($request->fails());
        $this->assertEquals($_POST['name'], $request->name());
        $this->assertEquals($_POST['email'], $request->email());
        $this->assertEquals($_POST['password'], $request->password());
    }
}