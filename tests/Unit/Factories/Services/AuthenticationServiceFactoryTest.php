<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Factories\Services\AuthenticationServiceFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class AuthenticationServiceFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AuthenticationServiceFactoryTest extends AbstractFactoriesTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent class.
        parent::setUp();

        // Makes sure the singleton is empty.
        $this->clearSingleton(AuthenticationServiceFactory::class);
    }

    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveAuthenticationServiceSingleton(): void
    {
        // Performs test.
        $service1 = AuthenticationServiceFactory::get();
        $service2 = AuthenticationServiceFactory::get();

        // Performs assertion.
        $this->assertSame($service1, $service2);
    }
}
