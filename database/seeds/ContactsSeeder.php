<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use NunoLopes\DomainContacts\Eloquent\Contact;
use NunoLopes\DomainContacts\Eloquent\User;

/**
 * Class ContactsSeeder.
 *
 * This class will seed the database with random contacts.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactsSeeder extends Seeder
{
    /**
     * @var Contact $model - Contacts Eloquent Model Instance.
     */
    private $model = null;

    /**
     * @var User $users - Users Eloquent Model Instance.
     */
    private $users = null;

    /**
     * @var Faker\Generator - Faker Generator Instance.
     */
    private $faker = null;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Make sure that there are Users seeded.
        $this->call(UsersSeeder::class);

        // Initiate dependencies.
        $this->model = new Contact();
        $this->users = new User();
        $this->faker = Factory::create();

        // Creates random contacts.
        $this->createRandomContacts();
    }

    /**
     * Creates Random Contacts.
     *
     * @param int $numUsers - Number of random users that we will create contacts for.
     * @param int $numContacts - Number of random contacts that we will create for each user.
     *
     * @return void
     */
    public function createRandomContacts(int $numUsers = 10, int $numContacts = 5): void
    {
        // Get random users with the limit set in the argument.
        $users = $this->users
                      ->inRandomOrder()
                      ->limit($numUsers)
                      ->get();

        // Creates random contacts for each user.
        foreach ($users as $user) {
            for ($j = 0; $j < $numContacts; $j++) {
                $this->model->create([
                    'user_id'      => $user->id,
                    'first_name'   => $this->faker->firstName,
                    'last_name'    => $this->faker->lastName,
                    'phone_number' => $this->faker->phoneNumber,
                    'email'        => $this->faker->unique()->email,
                ]);
            }
        }
    }
}
