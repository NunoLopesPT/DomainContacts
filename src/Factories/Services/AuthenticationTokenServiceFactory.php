<?php
namespace NunoLopes\DomainContacts\Factories\Services;

use NunoLopes\DomainContacts\Contracts\Services\AuthenticationTokenService;
use NunoLopes\DomainContacts\Factories\Repositories\ConfigurationRepositoryFactory;
use NunoLopes\DomainContacts\Services\AuthenticationToken\JwtAuthenticationTokenService;
use NunoLopes\DomainContacts\Utilities\Signatures\Sha256RsaSignature;

/**
 * Class AuthenticationTokenServiceFactory.
 *
 * This class will be used to create an AuthenticationTokenService instance.
 *
 * @package NunoLopes\DomainContacts
 */
class AuthenticationTokenServiceFactory
{
    /**
     * @var AuthenticationTokenService $service - Singleton instance of AuthenticationTokenService.
     */
    private static $service = null;

    /**
     * Create a new AuthenticationTokenService instance.
     *
     * @return AuthenticationTokenService
     */
    private static function create(): AuthenticationTokenService
    {
        return new JwtAuthenticationTokenService(
            new Sha256RsaSignature(),
            ConfigurationRepositoryFactory::get()->getRSA()
        );
    }

    /**
     * Get a new AuthenticationTokenService instance if not found or
     * return the one already created (Singleton).
     *
     * @return AuthenticationTokenService
     */
    public static function get(): AuthenticationTokenService
    {
        if (self::$service === null) {
            self::$service = self::create();
        }

        return self::$service;
    }
}
