<?php
namespace NunoLopes\Database\DomainContacts\Factories\Services;

use NunoLopes\Database\DomainContacts\Factories\MigrationsFactory;
use NunoLopes\Database\DomainContacts\Services\MigrationsService;

/**
 * Class MigrationsServiceFactory.
 *
 * @package NunoLopes\DomainContacts
 */
class MigrationsServiceFactory
{
    /**
     * @var MigrationsService $service - Migrations Singleton instance.
     */
    private static $service = null;

    /**
     * Creates a Migration Service Instance.
     *
     * @return MigrationsService
     */
    private static function create(): MigrationsService
    {
        return new MigrationsService(
            MigrationsFactory::get()
        );
    }

    /**
     * Gets a Singleton Migration Service Instance.
     *
     * @return MigrationsService
     */
    public static function get(): MigrationsService
    {
        if (self::$service === null) {
            self::$service = self::create();
        }

        return self::$service;
    }
}
