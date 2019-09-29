<?php
namespace NunoLopes\DomainContacts\Factories\Repositories;

use NunoLopes\DomainContacts\Contracts\Repositories\ConfigurationRepository;
use NunoLopes\DomainContacts\Repositories\Filesystem\FilesystemConfigurationRepository;

/**
 * Class ConfigurationRepositoryFactory.
 *
 * This class will be used to create an UsersRepository instance.
 *
 * @package NunoLopes\DomainContacts
 */
class ConfigurationRepositoryFactory
{
    /**
     * @var ConfigurationRepository $instance - Singleton instance of ConfigurationRepository.
     */
    private static $instance = null;

    /**
     * Create a new ConfigurationRepository instance.
     *
     * @return ConfigurationRepository
     */
    private static function create(): ConfigurationRepository
    {
        return new FilesystemConfigurationRepository();
    }

    /**
     * Get a new UsersRepository instance if not found or
     * return the one already created (Singleton).
     *
     * @return ConfigurationRepository
     */
    public static function get(): ConfigurationRepository
    {
        if (self::$instance === null) {
            self::$instance = self::create();
        }

        return self::$instance;
    }
}
