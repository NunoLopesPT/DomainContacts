<?php
namespace NunoLopes\Tests\DomainContacts\Integration\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Eloquent\User as Model;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserAlreadyCreatedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserNotFoundException;
use NunoLopes\DomainContacts\Repositories\Database\Eloquent\EloquentUsersRepository;
use NunoLopes\Tests\DomainContacts\Integration\AbstractIntegrationTest;

/**
 * Class EloquentUsersRepositoryTest.
 *
 * @package NunoLopes\Tests\DomainContacts
 */
class EloquentUsersRepositoryTest extends AbstractIntegrationTest
{
    /**
     * @var EloquentUsersRepository $repository - Eloquent Users Repository Instance.
     */
    private $repository = null;

    /**
     * @var Model $model - Eloquent Users Model Instance.
     */
    private $model = null;

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function setUp(): void
    {
        // Call parent function.
        parent::setUp();

        // Set private class variables.
        $this->model      = new Model();
        $this->repository = new EloquentUsersRepository(
            $this->model
        );
    }

    /**
     * Test if a user can be created and the creation ID returned.
     *
     * @return void
     */
    public function testUserCanBeCreated(): void
    {
        // Perform test.
        $user = $this->repository->create(
            new User([
                'name'     => 'DummyName',
                'email'    => 'DummyEmail',
                'password' => 'DummyPassword',
            ])
        );

        // Perform assertions.
        $this->assertInstanceOf(
            User::class,
            $user,
            'The creation of a user should return the User Entity.'
        );
        $this->assertTrue(
            $user->hasId(),
            'The user should have an ID.'
        );
        $this->assertNotNull(
            $user->createdAt(),
            'The created at shouldn\'t be null'
        );
        $this->assertTrue(
            empty($user->getDirtyAttributes()),
            'The dirty attributes should be empty.'
        );
    }

    /**
     * Test if a User with ID is beeing created, an exception is thrown.
     *
     * @return void
     */
    public function testUserCannotBeCreatedIfHasId(): void
    {
        // Creates expectation.
        $this->expectException(UserAlreadyCreatedException::class);

        // Perform test.
        $this->repository->create(
            new User([
                'id'       => 1,
                'name'     => 'DummyName',
                'email'    => 'DummyEmail',
                'password' => 'DummyPassword',
            ])
        );
    }

    /**
     * Tests that if we try to get an user with a negative ID an exception is thrown.
     *
     * @return void
     */
    public function testGetByIdFailsWithNegativeId(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        $this->repository->get(-1);
    }

    /**
     * Tests that if we try to get an user with a 0 ID an exception is thrown.
     *
     * @return void
     */
    public function testGetByIdFailsWithZeroId(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        $this->repository->get(0);
    }

    /**
     * Tests that if we try to get an user that doesn't exists an exception is thrown.
     *
     * @return void
     */
    public function testGetByIdFailsWithUserThatDoesNotExists(): void
    {
        // Creates expectation.
        $this->expectException(UserNotFoundException::class);

        // Performs test.
        $this->repository->get(2147483647);
    }

    /**
     * Tests that if we try to get an user that doesn't exists by its email an exception is thrown.
     *
     * @return void
     */
    public function testGetByEmailFailsWithUserThatDoesNotExists(): void
    {
        // Creates expectation.
        $this->expectException(UserNotFoundException::class);

        // Performs test.
        $this->repository->getByEmail($this->faker->email);
    }

    /**
     * Test that an User can be found by its ID.
     *
     * @return void
     */
    public function testUserCanBeGetById(): void
    {
        // Collects a random User.
        $model = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first();

        // Get the User from the Repository.
        $user = $this->repository->get($model->id);

        // Perform assertions
        $this->assertInstanceOf(
            User::class,
            $user,
            'The instance should be an User entity.'
        );
        $this->assertEquals(
            $user->id(),
            $model->id,
            'The ids should be equal.'
        );
        $this->assertEquals(
            $user->name(),
            $model->name,
            'The names should be equal.'
        );
        $this->assertEquals(
            $user->email(),
            $model->email,
            'The emails should be equal.'
        );
        $this->assertEquals(
            $user->password(),
            $model->password,
            'The passwords should be equal.'
        );
    }

    /**
     * Tests that if we try to get an user with an empty email an exception is thrown.
     *
     * @return void
     */
    public function testGetByEmailFailsWithEmptyString(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        $this->repository->getByEmail('');
    }

    /**
     * Tests that if we try to get an user with an email that is only empty spaces
     * an exception is thrown.
     *
     * @return void
     */
    public function testGetByEmailFailsWithStringWithEmptySpaces(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        $this->repository->getByEmail('    ');
    }

    /**
     * Test that an User can be found by its email.
     *
     * @return void
     */
    public function testUserCanBeFoundByEmail(): void
    {
        // Collects a random User.
        $model = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first();

        // Get the User from the Repository.
        $user = $this->repository->getByEmail($model->email);

        // Perform assertions
        $this->assertInstanceOf(
            User::class,
            $user,
            'The instance should be an User entity.'
        );
        $this->assertEquals(
            $user->id(),
            $model->id,
            'The ids should be equal.'
        );
        $this->assertEquals(
            $user->name(),
            $model->name,
            'The names should be equal.'
        );
        $this->assertEquals(
            $user->email(),
            $model->email,
            'The emails should be equal.'
        );
        $this->assertEquals(
            $user->password(),
            $model->password,
            'The passwords should be equal.'
        );
    }
}
