<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Database\Eloquent;

use NunoLopes\DomainContacts\Contracts\Repositories\ConfigurationRepository;
use NunoLopes\DomainContacts\Datatypes\DatabaseConfiguration;
use NunoLopes\DomainContacts\Factories\Database\Eloquent\CapsuleFactory;
use NunoLopes\DomainContacts\Factories\Repositories\ConfigurationRepositoryFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class CapsuleFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class CapsuleFactoryTest extends AbstractFactoriesTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent function.
        parent::setUp();

        // Makes sure the singleton is empty.
        $this->clearSingleton(CapsuleFactory::class);
    }

    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveCapsuleSingleton(): void
    {
        // Performs test.
        $capsule1 = CapsuleFactory::get();
        $capsule2 = CapsuleFactory::get();

        // Performs assertion.
        $this->assertSame(
            $capsule1,
            $capsule2,
            'The instances should have been the same.'
        );
    }

    /**
     * Tests that the retrieved capsule with the current configurations
     * doesn't fail.
     *
     * @coversNothing
     *
     * @return void
     */
    public function testCapsuleDoesntFailWithCurrentConfigurations(): void
    {
        // Performs test.
        $connection = CapsuleFactory::get()->getConnection()->getPdo();

        // Performs assertion.
        $this->assertNotNull(
            $connection,
            'The configurations of the database are not correct.'
        );
    }

    /**
     * Test that exception will be raised if the configurations are wrong.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @coversNothing
     *
     * @return void
     */
    public function testCapsuleFailsWithWrongConfigurations(): void
    {
        // Creates expectation.
        $this->expectException(\Exception::class);

        // Database configuration with wrong data.
        $databaseConfig = new DatabaseConfiguration(
            'localhost',
            'wrongUser',
            'wrongPass',
            'wrongName',
            'mysql'
        );

        // Mocks configuration repository.
        $configRepo = $this->createMock(ConfigurationRepository::class);
        $configRepo->expects($this->once())
                   ->method('getDatabase')
                   ->willReturn($databaseConfig);

        // Configures the Configuration Factory.
        $configFactory = \Mockery::mock('overload:' . ConfigurationRepositoryFactory::class);
        $configFactory->shouldReceive('get')
                      ->once()
                      ->andReturn($configRepo);

        // Performs test.
        CapsuleFactory::get()->getConnection()->getPdo();
    }
}
