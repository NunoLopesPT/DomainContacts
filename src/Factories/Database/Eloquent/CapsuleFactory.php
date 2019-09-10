<?php
namespace NunoLopes\DomainContacts\Factories\Database\Eloquent;

use Illuminate\Database\Capsule\Manager as Capsule;

require_once (__DIR__ . '/../../../../config.php');

/**
 * Class CapsuleFactory.
 *
 * This class is responsible for creating a singleton
 * database manager instance with the database configurations.
 *
 * @package NunoLopes\DomainContacts\Factories\Database\Eloquent
 */
class CapsuleFactory
{
    /**
     * @var Capsule $instance - Singleton Capsule instance.
     */
    private static $instance = null;

    /**
     * Creates a new Capsule instance.
     *
     * @return Capsule
     */
    private static function create(): Capsule
    {
        $capsule = new Capsule();

        // Add the configurations in the config file.
        // @todo Add a global way to input this configuration without the config file.
        $capsule->addConnection([
            'driver'    => DB_DRIVER,
            'host'      => DB_HOST,
            'database'  => DB_NAME,
            'username'  => DB_USER,
            'password'  => DB_PASS,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        // Set the capsule as global and boot the eloquent right away.
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }

    /**
     * Get a singleton Capsule instance.
     *
     * @return Capsule
     */
    public static function get(): Capsule
    {
        if (self::$instance === null) {
            self::$instance = self::create();
        }

        return self::$instance;
    }
}
