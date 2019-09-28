<?php
namespace NunoLopes\DomainContacts\Services;

use NunoLopes\DomainContacts\Contracts\Database\UsersRepository;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Entities\RequiredAttributeMissingException;
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
        if (!isset($attributes['password'])) {
            throw new RequiredAttributeMissingException('password');
        }

        // Converts the passsword to hash.
        $attributes['password'] = Hash::create($attributes['password']);

        // Saves the user in the persistent layer with the hashed password.
        $user = $this->usersRepository->create(new User($attributes));

        // Creates an authentication token .
        return $this->accessTokenService->createToken($user);
    }

    /**
     * Login a user by returning its credentials.
     *
     * @param string $email    - Email to search in the login.
     * @param string $password - Password of the user.
     *
     * @throws \InvalidArgumentException - If the email or the password is an empty string.
     * @throws PasswordMismatchException - If the password of the user doesn't match.
     * @throws UserNotFoundException     - If the user was not found.
     *
     * @return string
     */
    public function login(string $email, string $password): string
    {
        // Finds User by its email.
        $user = $this->usersRepository->getByEmail($email);

        // Checks if the passwords match the hash saved in the database.
        if (!Hash::verify($password, $user->password())) {
            throw new PasswordMismatchException();
        }

        // Creates a token so the user can access.
        return $this->accessTokenService->createToken($user);
    }
}
