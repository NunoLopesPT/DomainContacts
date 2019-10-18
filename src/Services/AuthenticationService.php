<?php
namespace NunoLopes\DomainContacts\Services;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\UsersRepository;
use NunoLopes\DomainContacts\Contracts\Utilities\Authentication;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserAlreadyCreatedException;
use NunoLopes\DomainContacts\Exceptions\Repositories\Users\UserNotFoundException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\PasswordMismatchException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\UserNotAuthenticatedException;
use NunoLopes\DomainContacts\Utilities\Hash;

/**
 * This Domain Service will be responsible for all Business Logic
 * related with the Authentication of the Users.
 *
 * @package NunoLopes\DomainContacts
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
     * @var Authentication $auth - Authentication manager instance.
     */
    private $auth = null;

    /**
     * AuthenticationService constructor.
     *
     * @param UsersRepository    $usersRepository    - User's Repository instance.
     * @param AccessTokenService $accessTokenService - AccessToken's Service instance.
     * @param Authentication     $auth               - Authentication manager instance.
     */
    public function __construct(
        UsersRepository $usersRepository,
        AccessTokenService $accessTokenService,
        Authentication $auth
    ) {
        $this->usersRepository = $usersRepository;
        $this->accessTokenService = $accessTokenService;
        $this->auth = $auth;
    }

    /**
     * Registers an user in the database.
     *
     * @param string $name - Name of the registred user.
     * @param string $email - Email of the registred user.
     * @param string $password - Unhashed password from the registred user.
     *
     * @throws UserAlreadyCreatedException - If the user already exists.
     *
     * @return string
     */
    public function register(string $name, string $email, string $password): string
    {
        // Creates the user with the hashed password.
        $user = new User([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::create($password),
        ]);

        // Saves the user in the persistent layer with the hashed password.
        $user = $this->usersRepository->create($user);

        // Creates an authentication token.
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

    /**
     * Returns the loggedin user.
     *
     * @throws UserNotAuthenticatedException - If no user is authenticated.
     *
     * @return User
     */
    public function user(): User
    {
        if ($this->auth->guest()) {
            throw new UserNotAuthenticatedException();
        }

        return $this->auth->user();
    }

    /**
     * Log-outs the current authenticated User.
     *
     * @throws UserNotAuthenticatedException - If no user is authenticated.
     *
     * @return bool
     */
    public function logout(): bool
    {
        if ($this->auth->guest()) {
            throw new UserNotAuthenticatedException();
        }

        return $this->accessTokenService->revokeToken($this->auth->accessToken());
    }
}
