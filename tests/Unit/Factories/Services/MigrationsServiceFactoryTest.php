<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Services;

use NunoLopes\DomainContacts\Factories\Services\Database\MigrationsServiceFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class MigrationsServiceFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class MigrationsServiceFactoryTest extends AbstractFactoriesTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent function.
        parent::setUp();
    }

    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @covers \NunoLopes\DomainContacts\Factories\Services\Database\MigrationsServiceFactory
     *
     * @return void
     */
    public function testCanRetrieveMigrationsServiceSingleton(): void
    {
        // Performs test.
        $repository1 = MigrationsServiceFactory::get();
        $repository2 = MigrationsServiceFactory::get();

        // Performs assertion.
        $this->assertSame(
            $repository1,
            $repository2,
            'The instances should have been the same.'
        );
    }
}
