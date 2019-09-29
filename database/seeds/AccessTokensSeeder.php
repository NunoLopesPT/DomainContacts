<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use NunoLopes\DomainContacts\Eloquent\AccessToken;
use NunoLopes\DomainContacts\Eloquent\User;
use NunoLopes\DomainContacts\Utilities\RandomGenerator;

/**
 * Class AccessTokensSeeder.
 *
 * This class will seed the database with random AccessTokens.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokensSeeder extends Seeder
{
    /**
     * @var AccessToken $model - AccessToken Eloquent Model Instance.
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
        $this->model = new AccessToken();
        $this->users = new User();
        $this->faker = Factory::create();

        // Creates random contacts.
        $this->createRandomAccessTokens();
    }

    /**
     * Creates Random Records.
     *
     * @param int $numUsers - Number of random users that we will create AccessTokens.
     *
     * @return void
     */
    public function createRandomAccessTokens(int $numUsers = 10): void
    {
        // Get random users with the limit set in the argument.
        $users = $this->users
                      ->inRandomOrder()
                      ->limit($numUsers)
                      ->get();

        // For each user, creates an AccessToken.
        foreach ($users as $user) {
            $this->model->create([
                'token_id'     => RandomGenerator::string(),
                'user_id'      => $user->id,
                'revoked'      => $this->faker->boolean,
                'expires_at'   => $this->faker->dateTimeBetween('+10 days', '+20 days')->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
