<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Factories\Repositories\ConfigurationRepositoryFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class ConfigurationsRepositoryFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class ConfigurationsRepositoryFactoryTest extends AbstractFactoriesTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent class.
        parent::setUp();

        // Makes sure the singleton is empty.
        $this->clearSingleton(ConfigurationRepositoryFactory::class);
    }

    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveContactsRepositorySingleton(): void
    {
        // Performs test.
        $repository1 = ConfigurationRepositoryFactory::get();
        $repository2 = ConfigurationRepositoryFactory::get();

        // Performs assertion.
        $this->assertSame(
            $repository1,
            $repository2,
            'The instances should have been the same.'
        );
    }
}
