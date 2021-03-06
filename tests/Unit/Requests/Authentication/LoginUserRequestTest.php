<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Requests\Authentication;

use NunoLopes\DomainContacts\Requests\Authentication\LoginUserRequest;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class LoginUserRequestTest.
 *
 * @package NunoLopes\DomainContacts
 */
class LoginUserRequestTest extends AbstractTest
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
        $request = new LoginUserRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test LoginUserRequest fails if there is no password.
     *
     * @return void
     */
    public function testLoginUserRequestFailsIfNoEmailIsPresent(): void
    {
        // Unsets required variable to test request.
        unset($_POST['email']);

        // Performs test.
        $request = new LoginUserRequest();

        // Performs assertion.
        $this->assertTrue($request->fails());
    }

    /**
     * Test LoginUserRequest succeeds.
     *
     * @return void
     */
    public function testLoginUserRequestSucceeds(): void
    {
        // Performs test.
        $request = new LoginUserRequest();

        // Performs assertions.
        $this->assertFalse($request->fails());
        $this->assertEquals($_POST['name'], $request->name());
        $this->assertEquals($_POST['password'], $request->password());
    }
}
