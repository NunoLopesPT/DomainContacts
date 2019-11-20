<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Factories\Repositories\Database\AccessTokenRepositoryFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class AccessTokensRepositoryFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokensRepositoryFactoryTest extends AbstractFactoriesTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent class.
        parent::setUp();

        // Makes sure the singleton is empty.
        $this->clearSingleton(AccessTokenRepositoryFactory::class);
    }

    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveAccessTokenRepositorySingleton(): void
    {
        // Performs test.
        $repository1 = AccessTokenRepositoryFactory::get();
        $repository2 = AccessTokenRepositoryFactory::get();

        // Performs assertion.
        $this->assertSame($repository1, $repository2);
    }
}
