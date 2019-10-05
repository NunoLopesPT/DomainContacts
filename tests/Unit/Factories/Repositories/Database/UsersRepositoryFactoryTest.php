<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Factories\Repositories\Database\UsersRepositoryFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class UsersRepositoryFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class UsersRepositoryFactoryTest extends AbstractFactoriesTest
{
    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent class.
        parent::setUp();

        // Makes sure the singleton is empty.
        $this->clearSingleton(UsersRepositoryFactory::class);
    }

    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveUsersRepositorySingleton(): void
    {
        // Performs test.
        $repository1 = UsersRepositoryFactory::get();
        $repository2 = UsersRepositoryFactory::get();

        // Performs assertion.
        $this->assertSame(
            $repository1,
            $repository2,
            'The instances should have been the same.'
        );
    }
}
