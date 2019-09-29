<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Factories\Repositories\Database;

use NunoLopes\DomainContacts\Factories\Repositories\Database\ContactsRepositoryFactory;
use NunoLopes\Tests\DomainContacts\Unit\Factories\AbstractFactoriesTest;

/**
 * Class ContactsRepositoryFactoryTest.
 *
 * @package NunoLopes\DomainContacts
 */
class ContactsRepositoryFactoryTest extends AbstractFactoriesTest
{
    /**
     * Test we are always retrieving the same instance from the factory.
     *
     * @return void
     */
    public function testCanRetrieveContactsRepositorySingleton(): void
    {
        // Performs test.
        $repository1 = ContactsRepositoryFactory::get();
        $repository2 = ContactsRepositoryFactory::get();

        // Performs assertion.
        $this->assertSame(
            $repository1,
            $repository2,
            'The instances should have been the same.'
        );
    }
}
