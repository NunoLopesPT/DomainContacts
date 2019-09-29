<?php
namespace NunoLopes\DomainContacts\Datatypes;

/**
 * Class DatabaseConfiguration.
 *
 * This is a Value Object.
 *
 * This class will carry all database configuration's needed.
 *
 * @package NunoLopes\DomainContacts\Datatypes
 */
class DatabaseConfiguration
{
    /**
     * @var string $host - The host location of the database.
     */
    private $host;

    /**
     * @var string $user - The database user name.
     */
    private $user;

    /**
     * @var string $pass - The Database User's password.
     */
    private $pass;

    /**
     * @var string $name - The name of the database.
     */
    private $name;

    /**
     * @var string $driver - The driver's name.
     */
    private $driver;

    /**
     * DatabaseConfiguration constructor.
     *
     * @param string $host   - The host location of the database.
     * @param string $user   - The database user name.
     * @param string $pass   - The Database User's password.
     * @param string $name   - The name of the database.
     * @param string $driver - The driver's name.
     */
    public function __construct(
        string $host,
        string $user,
        string $pass,
        string $name,
        string $driver
    ) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
        $this->driver = $driver;
    }

    /**
     * Returns the host location of the database.
     *
     * @return string
     */
    public function host(): string
    {
        return $this->host;
    }

    /**
     * Returns the database user name.
     *
     * @return string
     */
    public function user(): string
    {
        return $this->user;
    }

    /**
     * Returns the Database User's password.
     *
     * @return string
     */
    public function pass(): string
    {
        return $this->pass;
    }

    /**
     * Returns the name of the database.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Returns the driver's name.
     *
     * @return string
     */
    public function driver(): string
    {
        return $this->driver;
    }
}
