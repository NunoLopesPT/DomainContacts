<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Factories\Services\AccessTokenServiceFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class AccessTokenServiceFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenServiceFactoryTest extends AbstractFactoriesTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent class.
        parent::setUp();

        // Makes sure the singleton is empty.
        $this->clearSingleton(AccessTokenServiceFactory::class);
    }

    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveAccessTokenServiceSingleton(): void
    {
        // Performs test.
        $service1 = AccessTokenServiceFactory::get();
        $service2 = AccessTokenServiceFactory::get();

        // Performs assertion.
        $this->assertSame($service1, $service2);
    }
}
