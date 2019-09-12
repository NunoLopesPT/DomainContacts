<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use NunoLopes\DomainContacts\Eloquent\User;

/**
 * Class UsersSeeder.
 *
 * This class will seed the database with random users.
 *
 * @package NunoLopes\DomainContacts
 */
class UsersSeeder extends Seeder
{
    /**
     * @var bool $hasRun - Flag to avoid the seed beeing run multiple times.
     */
    private static $hasRun = false;

    /**
     * @var User $model - Users Eloquent Model Instance.
     */
    private $model;

    /**
     * @var Faker\Generator - Faker Generator Instance.
     */
    private $faker;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Check if the seed has already runned.
        if (self::$hasRun) {
            return;
        }

        // Start dependencies.
        $this->model = new User();
        $this->faker = Factory::create();

        // Create 10 random users.
        $this->createRandomUsers();
    }

    /**
     * Creates Random Users.
     *
     * @param int $num - Number of random records to be created.
     *
     * @return void
     */
    public function createRandomUsers(int $num = 10): void
    {
        for ($i = 0; $i < $num; $i++) {
            $this->model->create([
                'name'     => $this->faker->name,
                'email'    => $this->faker->unique()->email,
                'password' => $this->faker->password,
            ]);
        }
    }
}
