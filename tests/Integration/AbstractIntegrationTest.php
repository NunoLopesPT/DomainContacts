<?php
namespace NunoLopes\Tests\DomainContacts\Integration;

use NunoLopes\DomainContacts\Factories\Database\Eloquent\CapsuleFactory;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class AbstractIntegrationTest.
 *
 * This class will add extra funcionality to all Integration tests, by having
 * database transactions and allow the tests to be run multiple times without having
 * for example to repopulate the database with seeds or having it "overpopulated".
 *
 * All integration tests must extend this Class.
 *
 * @package NunoLopes\Tests\DomainContacts\Integration
 */
abstract class AbstractIntegrationTest extends AbstractTest
{
    /**
     * This method is called before the first test of this test class is run.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        // Calls parent function.
        parent::setUpBeforeClass();

        // Collect capsule.
        $capsule = CapsuleFactory::get();

        // Boot Eloquent.
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Start transaction.
        $capsule->getConnection()->beginTransaction();
    }

    /**
     * This method is called after the last test of this test class is run.
     *
     * @return  void
     */
    public static function tearDownAfterClass(): void
    {
        // Calls parent function.
        parent::tearDownAfterClass();

        // Collect capsule.
        $capsule = CapsuleFactory::get();

        // Rollback all changes to the database made.
        $capsule->getConnection()->rollBack();
    }
}
