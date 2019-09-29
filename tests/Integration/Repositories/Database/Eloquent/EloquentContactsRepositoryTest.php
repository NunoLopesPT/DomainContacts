<?php
namespace NunoLopes\Tests\DomainContacts\Integration\Repositories\Database\Eloquent;

use NunoLopes\DomainContacts\Eloquent\Contact as Model;
use NunoLopes\DomainContacts\Eloquent\User;
use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Exceptions\Repositories\Contacts\ContactNotFoundException;
use NunoLopes\DomainContacts\Repositories\Database\Eloquent\EloquentContactsRepository;
use NunoLopes\Tests\DomainContacts\Integration\AbstractIntegrationTest;

/**
 * Class EloquentUsersRepositoryTest.
 *
 * @package NunoLopes\Tests\DomainContacts
 */
class EloquentContactsRepositoryTest extends AbstractIntegrationTest
{
    /**
     * @var EloquentContactsRepository $repository - Eloquent Contacts Repository Instance.
     */
    private $repository = null;

    /**
     * @var Model $model - Eloquent Contacts Model Instance.
     */
    private $model = null;

    /**
     * @var User $user - Eloquent Users Model Instance.
     */
    private $user = null;

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function setUp(): void
    {
        // Call parent function.
        parent::setUp();

        $this->user = new User();

        // Set private class variables.
        $this->model = new Model();
        $this->repository = new EloquentContactsRepository(
            $this->model
        );
    }

    /**
     * Test if a user can be created and the creation ID returned.
     *
     * @return void
     */
    public function testContactCanBeCreated(): void
    {
        $user = $this->user->inRandomOrder()->first();

        // Perform test.
        $contact = $this->repository->create(
            new Contact([
                'user_id'      => $user->id,
                'first_name'   => $this->faker->firstName,
                'last_name'    => $this->faker->lastName,
                'phone_number' => $this->faker->phoneNumber,
                'email'        => $this->faker->unique()->email,
            ])
        );

        // Perform assertions.
        $this->assertInstanceOf(
            Contact::class,
            $contact,
            'The creation of a user should return a Contact.'
        );
        $this->assertTrue(
            $contact->hasId(),
            'The contact should have an ID.'
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
        $this->expectException(ContactNotFoundException::class);

        // Performs test.
        $this->repository->get(12312312);
    }

    /**
     * Test that a Contact can be get by its ID.
     *
     * @return void
     */
    public function testContactCanBeGetById(): void
    {
        // Collects a random User.
        $model = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first();

        // Get the Contact from the Repository.
        $contact = $this->repository->get($model->id);

        // Perform assertions
        $this->assertInstanceOf(
            Contact::class,
            $contact,
            'The instance should be an User entity.'
        );
        $this->assertEquals(
            $contact->id(),
            $model->id,
            'The ids should be equal.'
        );
        $this->assertEquals(
            $contact->userId(),
            $model->user_id,
            'The user id should be equal.'
        );
        $this->assertEquals(
            $contact->firstName(),
            $model->first_name,
            'The first names should be equal.'
        );
        $this->assertEquals(
            $contact->lastName(),
            $model->last_name,
            'The last names should be equal.'
        );
        $this->assertEquals(
            $contact->phoneNumber(),
            $model->phone_number,
            'The phone numbers should be equal.'
        );
        $this->assertEquals(
            $contact->email(),
            $model->email,
            'The emails should be equal.'
        );
    }

    /**
     * Test that a Contact can be get by its ID.
     *
     * @return void
     */
    public function testContactCanBeFoundByUserId(): void
    {
        // Collects a random User.
        $model = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first();

        // Get the Contact from the Repository.
        $contacts = $this->repository->findByUserId($model->user_id);

        // Perform assertions on each retrieved contact.
        foreach ($contacts as $contact) {
            $this->assertInstanceOf(
                Contact::class,
                $contact,
                'The instance should be a Contact entity.'
            );
            $this->assertEquals(
                $contact->userId(),
                $model->user_id,
                'The owner of the contact should be equal.'
            );
        }

        // Test that the total amount of records is the same.
        $this->assertEquals(
            $this->model->where('user_id', $model->user_id)->count(),
            \count($contacts),
            'The lenght of the retrieved list should be equal'
        );
    }

    /**
     * Test that a Contact can be destroyed.
     *
     * @return void
     */
    public function testContactCanBeDestroyed(): void
    {
        // Collects a random Contact.
        $model = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first();

        // Assert that a contact was returned.
        $this->assertNotNull(
            $model,
            'No contact was found in the database.'
        );

        // Performs test.
        $result = $this->repository->destroy($model->id);

        // Try to collect the deleted contact.
        $model = $this->model
            ->newQuery()
            ->whereKey($model->id)
            ->first();

        // Assert that the delete operation was successful and the contact wasn't found.
        $this->assertTrue(
            $result,
            'The operation should have returned true.'
        );
        $this->assertNull(
            $model,
            'The contact should have been deleted.'
        );
    }

    /**
     * Test that a contact can be updated.
     *
     * @return void
     */
    public function testContactCanBeUpdated(): void
    {
        // Get a random Contact.
        $attributes = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first()
            ->getAttributes();
        $contact = new Contact($attributes);

        // Change all the attributes.
        $newAttributes = [
            'first_name' => $contact->firstName() . '.',
            'last_name'  => $contact->lastName() . '.',
            'phone_number' => $contact->phoneNumber() . '.',
            'email'        => $contact->email() . '.',
        ];
        $contact->setAttributes($newAttributes);

        // Perform test.
        $result = $this->repository->update($contact);

        // Assert the operation was successful and the attributes were updated.
        $this->assertSame(
            $result,
            $contact,
            'The result operation should have returned true.'
        );
        $this->assertTrue(
            empty($contact->getDirtyAttributes()),
            'The dirty attributes should be empty.'
        );
        $this->assertEquals(
            $contact->firstName(),
            $newAttributes['first_name'],
            'The first name was not updated.'
        );
        $this->assertEquals(
            $contact->lastName(),
            $newAttributes['last_name'],
            'The last name was not updated.'
        );
        $this->assertEquals(
            $contact->phoneNumber(),
            $newAttributes['phone_number'],
            'The phone number was not updated.'
        );
        $this->assertEquals(
            $contact->email(),
            $newAttributes['email'],
            'The email was not updated.'
        );
    }

    /**
     * Test that a contact that has no changed attributes, will return exactly the same
     * instance with no changed attributes.
     *
     * @return void
     */
    public function testContactNotChangedIsNotUpdated(): void
    {
        // Get a random Contact.
        $attributes = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first()
            ->getAttributes();
        $contact = new Contact($attributes);

        // Clone the contact so we can compare after.
        $clone = clone $contact;

        // Perform test.
        $result = $this->repository->update($contact);

        // Assert the operation was successful and the attributes were not updated.
        $this->assertEquals(
            $clone,
            $result,
            'The result operation should have returned true.'
        );
    }

    /**
     * Test when trying to update a contact without an ID.
     *
     * @return void
     */
    public function testContactUpdateFailsIfContactHasNoId(): void
    {
        // Creates expectation.
        $this->expectException(\UnexpectedValueException::class);

        // Get a random Contact attributes.
        $attributes = $this->model
            ->newQuery()
            ->inRandomOrder()
            ->first()
            ->getAttributes();

        // Remove the ID from the attributes.
        unset($attributes['id']);

        // Create the contact without an ID.
        $contact = new Contact($attributes);

        // Perform test.
        $this->repository->update($contact);
    }
}
