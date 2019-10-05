<?php
namespace NunoLopes\Tests\DomainContacts\Integration\Entities;

use NunoLopes\DomainContacts\Eloquent\Contact as Model;
use NunoLopes\DomainContacts\Entities\Contact;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserNotFoundException;
use NunoLopes\Tests\DomainContacts\Integration\AbstractIntegrationTest;

/**
 * Class ContactTest.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactTest extends AbstractIntegrationTest
{
    /**
     * @var Model $model - Eloquent Contacts Model Instance.
     */
    private $model = null;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Call parent function.
        parent::setUp();

        // Set private class variables.
        $this->model = new Model();
    }

    /**
     * Test can directly retrieve the User of a Contact from the database.
     *
     * @return void
     */
    public function testCanRetrieveUser(): void
    {
        // Get random Contact from the database.
        $contact = new Contact(
            $this->model
                 ->newQuery()
                 ->inRandomOrder()
                 ->first()
                 ->getAttributes()
        );

        // Get the user from the databsae.
        $user = $contact->user();

        // Perform assertions.
        $this->assertInstanceOf(
            User::class,
            $user,
            'The returned instance should have been an User Entity.'
        );
        $this->assertEquals(
            $contact->userId(),
            $user->id(),
            'The user IDs should be equal.'
        );
    }

    /**
     * Test that if the Contact has an User that doesn't exists an exception is thrown.
     *
     * @return void
     */
    public function testRetrieveUserFailsIfNotFound(): void
    {
        // Creates expectation.
        $this->expectException(UserNotFoundException::class);

        // Create random attributes with an user that doesn't exists.
        $attributes = [
            'id'           => $this->faker->numberBetween(),
            'user_id'      => 2147483647,
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email'        => $this->faker->email,
        ];

        // Creates the Contact and performs test.
        $contact = new Contact($attributes);
        $contact->user();
    }
}
