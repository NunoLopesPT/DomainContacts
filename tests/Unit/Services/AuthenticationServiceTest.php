<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Services;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\UsersRepository;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Entities\RequiredAttributeMissingException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\PasswordMismatchException;
use NunoLopes\DomainContacts\Services\AccessTokenService;
use NunoLopes\DomainContacts\Services\AuthenticationService;
use NunoLopes\DomainContacts\Utilities\Hash;
use NunoLopes\Tests\DomainContacts\AbstractTest;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class AuthenticationServiceTest.
 *
 * @covers \NunoLopes\DomainContacts\Services\AuthenticationService
 *
 * @package NunoLopes\DomainContacts
 */
class AuthenticationServiceTest extends AbstractTest
{
    /**
     * @var MockObject|UsersRepository $users - Users Repository Mocked Instance.
     */
    private $users = null;

    /**
     * @var MockObject|AccessTokenService $accessToken - AccessToken Service Mocked Instance.
     */
    private $accessToken = null;

    /**
     * @var AuthenticationService $service - Authentication Service Instance.
     */
    private $service = null;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent function.
        parent::setUp();

        // Mock dependencies.
        $this->users       = $this->createMock(UsersRepository::class);
        $this->accessToken = $this->createMock(AccessTokenService::class);

        // Instantiates Service.
        $this->service = new AuthenticationService($this->users, $this->accessToken);
    }

    /**
     * Test we can register a new user.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function testCanRegisterUser(): void
    {
        // Create random attributes.
        $attributes = [
            'name'     => $this->faker->name,
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];

        // Mocks User instance.
        $user = $this->createMock(User::class);

        // Mocks Hard Dependency so test run faster.
        $hash = \Mockery::mock('overload:' . Hash::class);
        $hash->expects('create')
             ->withAnyArgs()
             ->andReturn('hashedPassword');

        // Mocks User's Repository.
        $this->users
             ->expects($this->once())
             ->method('create')
             ->withAnyParameters()
             ->willReturn($user);

        // Mocks AccessToken's Repository.
        $this->accessToken
             ->expects($this->once())
             ->method('createToken')
             ->with($user)
             ->willReturn('token');

        // Performs test.
        $result = $this->service->register($attributes);

        // Performs assertions.
        $this->assertIsString(
            $result,
            'The result of the register must be a string (token).'
        );
    }

    /**
     * Test we cannot register an user if the password in the attributes is missing.
     *
     * @return void
     */
    public function testCannotRegisterUserIfPasswordIsMissing(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        // Create random attributes.
        $attributes = [
            'name'     => $this->faker->userName,
            'email'    => $this->faker->email,
        ];

        // Performs test.
        $this->service->register($attributes);
    }

    /**
     * Test we cannot register an user if the attributes array is empty.
     *
     * @return void
     */
    public function testCannotRegisterUserIfAttributesAreEmpty(): void
    {
        // Creates expectation.
        $this->expectException(RequiredAttributeMissingException::class);

        $this->service->register([]);
    }

    /**
     * Test we can register a new user.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @return void
     */
    public function testCanLoginUserIfPasswordMatches(): void
    {
        // Randomly created password and 'its' hash.
        $password       = $this->faker->password;
        $hashedPassword = 'hashedPassword';

        // Mocks Hard Dependency so test runs faster.
        $hash = \Mockery::mock('overload:' . Hash::class);
        $hash->expects('verify')
             ->with($password, $hashedPassword)
             ->andReturn($hashedPassword);

        // Mocks an User Entity with an hashed password.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('password')
             ->willReturn($hashedPassword);

        // Mocks User's Repository.
        $this->users
             ->expects($this->once())
             ->method('getByEmail')
             ->with()
             ->willReturn($user);

        // Performs test.
        $result = $this->service->login(
            $this->faker->email,
            $password
        );

        // Performs assertions.
        $this->assertIsString(
            $result,
            'The result of the register must be a string.'
        );
        $this->assertNotEquals(
            $result,
            $password,
            'The return should not be the password.'
        );
        $this->assertNotEquals(
            $result,
            $hashedPassword,
            'The result should not be the hashed password.'
        );
    }

    /**
     * Test we can register a new user.
     *
     * @return void
     */
    public function testCanNotLoginUserIfPasswordDoesNotMatch(): void
    {
        // Creates Expectation.
        $this->expectException(PasswordMismatchException::class);

        // Generates a password.
        $password = $this->faker->password;

        // Mocks an User Entity with an hashed password.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('password')
            ->willReturn("WrongHash");

        // Mocks User's Repository.
        $this->users
            ->expects($this->once())
            ->method('getByEmail')
            ->with()
            ->willReturn($user);

        // Performs test.
        $this->service->login(
            $this->faker->email,
            $password
        );
    }
}
