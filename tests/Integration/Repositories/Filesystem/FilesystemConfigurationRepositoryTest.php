<?php
namespace NunoLopes\Tests\DomainContacts\Integration\Repositories\Filesystem;

use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;
use NunoLopes\DomainContacts\Datatypes\DatabaseConfiguration;
use NunoLopes\DomainContacts\Repositories\Filesystem\FilesystemConfigurationRepository;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class FilesystemConfigurationRepositoryTest
 *
 * @package NunoLopes\DomainContacts
 */
class FilesystemConfigurationRepositoryTest extends AbstractTest
{
    /**
     * @var FilesystemConfigurationRepository - Filesystem Repository instance.
     */
    private $config = null;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->config = new FilesystemConfigurationRepository();
    }

    /**
     * Test that can get the database configurations.
     *
     * @return void
     */
    public function testCanGetDatabaseConfigurations(): void
    {
        // Performs test.
        $databaseConfig = $this->config->getDatabase();

        // Performs assertion.
        $this->assertInstanceOf(
            DatabaseConfiguration::class,
            $databaseConfig
        );
    }

    /**
     * Test that can get the database configurations.
     *
     * @return void
     */
    public function testCanGetRsaConfigurations(): void
    {
        // Performs test.
        $rsaConfig = $this->config->getRsa();

        // Performs assertion.
        $this->assertInstanceOf(
            AsymmetricCryptography::class,
            $rsaConfig
        );
    }
}