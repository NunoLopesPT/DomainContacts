<?php
namespace NunoLopes\DomainContacts\Factories\Services\Database;

use NunoLopes\DomainContacts\Factories\Database\Eloquent\CapsuleFactory;
use NunoLopes\DomainContacts\Services\Database\SeedsService;

/**
 * Class SeedsServiceFactory.
 *
 * @package NunoLopes\DomainContacts
 */
class SeedsServiceFactory
{
    /**
     * @var SeedsService $service - Seeds Service Singleton instance.
     */
    private static $service = null;

    /**
     * Creates a Seeds Service Instance.
     *
     * @return SeedsService
     */
    private static function create(): SeedsService
    {
        // Boot eloquent instance.
        CapsuleFactory::get();

        return new SeedsService();
    }

    /**
     * Gets a Singleton Seeds Service Instance.
     *
     * @return SeedsService
     */
    public static function get(): SeedsService
    {
        if (self::$service === null) {
            self::$service = self::create();
        }

        return self::$service;
    }
}
