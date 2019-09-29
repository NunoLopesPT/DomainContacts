<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Database\Eloquent;

use NunoLopes\DomainContacts\Factories\Database\Eloquent\MigrationsFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class CapsuleFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class MigrationsFactoryTest extends AbstractFactoriesTest
{
    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveMigrationsSingleton(): void
    {
        // Performs test.
        $migrator1 = MigrationsFactory::get();
        $migrator2 = MigrationsFactory::get();

        // Performs assertion.
        $this->assertSame(
            $migrator1,
            $migrator2,
            'The instances should have been the same.'
        );
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->clearSingleton(MigrationsFactory::class);
    }
}
