<?php
namespace NunoLopes\DomainContacts\Services;

use NunoLopes\DomainContacts\Contracts\Database\UsersRepository;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserNotFoundException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\PasswordMismatchException;
use NunoLopes\DomainContacts\Utilities\Hash;

/**
 * This Domain Service will be responsible for all Business Logic
 * related with the Authentication of the Users.
 *
 * @package NunoLopes\LaravelContactsAPI
 */
class AuthenticationService
{
    /**
     * @var UsersRepository $usersRepository - User's Repository instance.
     */
    private $usersRepository = null;

    /**
     * @var AccessTokenService $accessTokenService - AccessToken's Service instance.
     */
    private $accessTokenService = null;

    /**
     * AuthenticationService constructor.
     *
     * @param UsersRepository    $usersRepository    - User's Repository instance.
     * @param AccessTokenService $accessTokenService - AccessToken's Service instance.
     */
    public function __construct(
        UsersRepository $usersRepository,
        AccessTokenService $accessTokenService
    ) {
        $this->usersRepository = $usersRepository;
        $this->accessTokenService = $accessTokenService;
    }

    /**
     * Registers an user in the database.
     *
     * @param array $attributes - Related attributes with the registration.
     *
     * @return string
     */
    public function register (array $attributes): string
    {
        // Converts the password with an one-way hash.
        $attributes['password'] = Hash::create($attributes['password']);

        // Saves the user in the persistent layer with the hashed password.
        $id = $this->usersRepository->create(new User($attributes));

        // Creates an authentication token .
        return $this->accessTokenService->createToken($this->usersRepository->get($id));
    }

    /**
     * Login a user by returning its credentials.
     *
     * @param array $attributes - Related attributes with the login.
     *
     * @throws PasswordMismatchException  - If the password of the user doesn't match.
     * @throws UserNotFoundException      - If the user was not found.
     *
     * @return mixed
     */
    public function login (array $attributes) {

        // Finds User by its email.
        $user = $this->usersRepository->getByEmail($attributes['email']);

        // Checks if the passwords match the hash saved in the database.
        if (!Hash::verify($attributes['password'], $user->password())) {
            throw new PasswordMismatchException();
        }

        // Creates a token so the user can access.
        return $this->accessTokenService->createToken($user);
    }
}
