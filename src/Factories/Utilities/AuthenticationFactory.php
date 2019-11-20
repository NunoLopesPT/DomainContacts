<?php
namespace NunoLopes\DomainContacts\Factories\Utilities;

use NunoLopes\DomainContacts\Contracts\Utilities\Authentication;
use NunoLopes\DomainContacts\Utilities\Authentication as AuthManager;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\TokenRevokedException;
use NunoLopes\DomainContacts\Factories\Services\AccessTokenServiceFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthenticationFactory.
 *
 * This class is responsible for creating a singleton
 * database manager instance with the database configurations.
 *
 * @package NunoLopes\DomainContacts\Factories\Database\Eloquent
 */
class AuthenticationFactory
{
    /**
     * @var Authentication $auth - Singleton Capsule instance.
     */
    private static $auth = null;

    /**
     * Creates a new Capsule instance.
     *
     * @throws TokenRevokedException - If the current token is revoked.
     *
     * @return Authentication
     */
    private static function create(): Authentication
    {
        // Get the request to check the authorization token.
        $request = Request::createFromGlobals();

        // Default value if no token was sent.
        $accessToken = null;

        if ($request->headers->has('Authorization')) {
            $bearerToken = $request->headers->get('Authorization');

            // Search if the token is a Bearer.
            if (\strpos($bearerToken, 'Bearer ') !== 0) {
                throw new \UnexpectedValueException('The authorization is not a Bearer token.');
            }

            // Remove the Bearer from the token.
            $jwt = \substr($bearerToken, 7);

            // Get the AccessToken.
            $accessToken = AccessTokenServiceFactory::get()->getAccessToken($jwt);

            // Throw exception if the token is revoked.
            if ($accessToken->revoked()) {
                throw new TokenRevokedException();
            }
        }

        return new AuthManager($accessToken);
    }

    /**
     * Get a singleton Capsule instance.
     *
     * @return Authentication
     */
    public static function get(): Authentication
    {
        if (self::$auth === null) {
            self::$auth = self::create();
        }

        return self::$auth;
    }
}
