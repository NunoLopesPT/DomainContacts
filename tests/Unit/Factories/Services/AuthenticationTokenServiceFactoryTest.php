<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Factories\Services\AuthenticationTokenServiceFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class AuthenticationTokenServiceFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AuthenticationTokenServiceFactoryTest extends AbstractFactoriesTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent class.
        parent::setUp();

        // Makes sure the singleton is empty.
        $this->clearSingleton(AuthenticationTokenServiceFactory::class);
    }

    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveAuthenticationTokenServiceSingleton(): void
    {
        // Performs test.
        $service1 = AuthenticationTokenServiceFactory::get();
        $service2 = AuthenticationTokenServiceFactory::get();

        // Performs assertion.
        $this->assertSame($service1, $service2);
    }
}
