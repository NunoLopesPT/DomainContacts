<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Services;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\ContactsRepository;
use NunoLopes\DomainContacts\Contracts\Utilities\Authentication;
use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotDeletedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotFoundException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\UserNotAuthenticatedException;
use NunoLopes\DomainContacts\Services\ContactsService;
use NunoLopes\Tests\DomainContacts\AbstractTest;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class ContactsServiceTest.
 *
 * @covers \NunoLopes\DomainContacts\Services\ContactsService
 *
 * @package NunoLopes\DomainContacts
 */
class ContactsServiceTest extends AbstractTest
{
    /**
     * @var MockObject|ContactsRepository $contacts - Contacts Repository Mocked Instance.
     */
    private $contacts = null;

    /**
     * @var MockObject|Authentication $auth - Authentication Mocked Instance.
     */
    private $auth = null;

    /**
     * @var ContactsService $service - Contacts Service Instance.
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
        $this->contacts = $this->createMock(ContactsRepository::class);
        $this->auth     = $this->createMock(Authentication::class);

        // Instantiates Service.
        $this->service = new ContactsService($this->contacts, $this->auth);

    }

    /**
     * Test that a contact can be created if there is a loggedin user.
     *
     * @return void
     */
    public function testAllContactsCanBeRetrieveIfUserIsLoggedIn(): void
    {
        // Mock authenticated User entity.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('findByUserId')
             ->with(1)
             ->willReturn([]);

        // Perform test
        $result = $this->service->listAllContactsOfAuthenticatedUser();

        // Performs assertions.
        $this->assertEquals(
            $result,
            [],
            'The results are not equal'
        );
    }

    /**
     * Test that a contact cannot be created if there is no loggedin user.
     *
     * @return void
     */
    public function testAllUserContactsCanNotBeRetrieveIfUserIsNotLoggedIn(): void
    {
        // Creates expectation.
        $this->expectException(UserNotAuthenticatedException::class);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn(null);

        // Perform test
        $this->service->listAllContactsOfAuthenticatedUser();
    }

    /**
     * Test that a contact can be created if there is a loggedin user.
     *
     * @return void
     */
    public function testAContactsCanBeCreatedIfAUserIsLoggedIn(): void
    {
        // Mock authenticated User entity.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('create')
             ->willReturn($this->createMock(Contact::class));

        // Perform test
        $result = $this->service->create([
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'email'        => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
        ]);

        // Performs assertions.
        $this->assertInstanceOf(
            Contact::class,
            $result,
            'The results should be a Contact Entity.'
        );
    }

    /**
     * Test that a contact can be created if there is a loggedin user.
     *
     * @return void
     */
    public function testContactCannotBeCreatedIfNoUserIsLoggedIn(): void
    {
        // Creates expectation.
        $this->expectException(UserNotAuthenticatedException::class);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn(null);

        // Perform test
        $this->service->create([
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'email'        => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
        ]);
    }

    /**
     * Test that a contact can be retrieved for editing if the user is authenticated
     * and the contact exists.
     *
     * @return void
     */
    public function testCanRetrieveContactToEditIfExistsAndUserLoggedIn(): void
    {
        // Mock authenticated User entity.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock contact that is going to be edited.
        $contact = $this->createMock(Contact::class);
        $contact->expects($this->once())
                ->method('userId')
                ->willReturn(1);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('get')
             ->with(1)
             ->willReturn($contact);

        // Perform test
        $result = $this->service->edit(1);

        // Performs assertion.
        $this->assertEquals(
            $result,
            $contact,
            'The returned value is different.'
        );
    }

    /**
     * Test that a contact cannot be found if the Authenticated
     * User's ID is different from the Contact's User ID.
     *
     * @return void
     */
    public function testCannotRetrieveContactToEditIfOwnerIsDifferentDoesNotExists(): void
    {
        // Creates expectation.
        $this->expectException(ContactNotFoundException::class);

        // Mock authenticated User entity, with a different ID than the
        // Contact's User ID.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock contact that is going to be edited, with a
        // different User ID from the Authenticated User ID.
        $contact = $this->createMock(Contact::class);
        $contact->expects($this->once())
                ->method('userId')
                ->willReturn(2);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('get')
             ->with(1)
             ->willReturn($contact);

        // Perform test
        $this->service->edit(1);
    }

    /**
     * Test that a contact can not be eddited if there is no loggedin user.
     *
     * @return void
     */
    public function testContactCannotBeEditedIfNoUserIsLoggedIn(): void
    {
        // Creates expectation.
        $this->expectException(UserNotAuthenticatedException::class);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn(null);

        // Perform test
        $this->service->edit(1);
    }

    /**
     * Test that a contact can be updated if it exists and the user is logged-in.
     *
     * @return void
     */
    public function testCanUpdateContactIfExistsAndUserLoggedIn(): void
    {
        // Mock authenticated User entity.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('id')
            ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock contact that is going to be edited.
        $contact = $this->createMock(Contact::class);
        $contact->expects($this->once())
                ->method('userId')
                ->willReturn(1);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('update')
             ->withAnyParameters()
             ->willReturn($contact);
        $this->contacts
             ->expects($this->once())
             ->method('get')
             ->with(1)
             ->willReturn($contact);

        // New attributes of the contact.
        $attributes = [
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'email'        => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
        ];

        // Perform test
        $result = $this->service->update(1, $attributes);

        // Performs assertion.
        $this->assertInstanceOf(
            Contact::class,
            $result,
            'The returned instance should be a Contact instance.'
        );
        $this->assertSame(
            $result,
            $contact,
            'The returned instancce is different.'
        );
    }

    /**
     * Test that a contact can be updated if it exists and the user is logged-in.
     *
     * @return void
     */
    public function testCannotUpdateContactIfOwnerIsDifferent(): void
    {
        // Creates expectation.
        $this->expectException(ContactNotFoundException::class);

        // Mock authenticated User entity.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock contact that is going to be edited.
        $contact = $this->createMock(Contact::class);
        $contact->expects($this->once())
                ->method('userId')
                ->willReturn(2);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('get')
             ->with(1)
             ->willReturn($contact);

        // New attributes of the contact.
        $attributes = [
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'email'        => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
        ];

        // Perform test
        $this->service->update(1, $attributes);
    }

    /**
     * Test that a contact can not be updated if there is no loggedin user.
     *
     * @return void
     */
    public function testContactCannotBeUpdatedIfNoUserIsLoggedIn(): void
    {
        // Creates expectation.
        $this->expectException(UserNotAuthenticatedException::class);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn(null);

        // New attributes of the contact.
        $attributes = [
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'email'        => $this->faker->email,
            'phone_number' => $this->faker->phoneNumber,
        ];

        // Perform test
        $this->service->update(1, $attributes);
    }

    /**
     * Test that a Contact can be destroyed if the user is loggedin and the
     * owner of the contact is the same.
     *
     * @return void
     */
    public function testContactCanBeDestroyed(): void
    {
        // Mock authenticated User entity.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock contact that is going to be edited.
        $contact = $this->createMock(Contact::class);
        $contact->expects($this->once())
                ->method('userId')
                ->willReturn(1);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('destroy')
             ->withAnyParameters()
             ->willReturn(true);
        $this->contacts
             ->expects($this->once())
             ->method('get')
             ->with(1)
             ->willReturn($contact);

        // Perform test
        $this->service->destroy(1);
    }

    /**
     * Test that a contact cannot be destroyed if the owner is different.
     *
     * @return void
     */
    public function testCannotDestroyContactIfOwnerIsDifferent(): void
    {
        // Creates expectation.
        $this->expectException(ContactNotFoundException::class);

        // Mock authenticated User entity.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock contact that is going to be edited.
        $contact = $this->createMock(Contact::class);
        $contact->expects($this->once())
                ->method('userId')
                ->willReturn(2);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('get')
             ->with(1)
             ->willReturn($contact);

        // Perform test
        $this->service->destroy(1);
    }

    /**
     * Test that a contact can not be destroyed if there is no loggedin user.
     *
     * @return void
     */
    public function testContactCannotBeDestroyedIfNoUserIsLoggedIn(): void
    {
        // Creates expectation.
        $this->expectException(UserNotAuthenticatedException::class);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn(null);

        // Perform test
        $this->service->destroy(1);
    }

    /**
     * Test that an Exception is thrown if the destroy fails.
     *
     * @return void
     */
    public function testExceptionIsThrownIfDestroyFails(): void
    {
        // Creates expectation.
        $this->expectException(ContactNotDeletedException::class);

        // Mock authenticated User entity.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Mock authentication.
        $this->auth
             ->expects($this->once())
             ->method('user')
             ->willReturn($user);

        // Mock contact that is going to be edited.
        $contact = $this->createMock(Contact::class);
        $contact->expects($this->once())
                ->method('userId')
                ->willReturn(1);

        // Mock ContactsRepository.
        $this->contacts
             ->expects($this->once())
             ->method('get')
             ->with(1)
             ->willReturn($contact);
        $this->contacts
             ->expects($this->once())
             ->method('destroy')
             ->withAnyParameters()
             ->willReturn(false);

        // Perform test
        $this->service->destroy(1);
    }
}
