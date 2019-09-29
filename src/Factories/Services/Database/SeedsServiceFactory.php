<?php
namespace NunoLopes\DomainContacts\Factories\Services;

use NunoLopes\DomainContacts\Services\SeedsService;

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
