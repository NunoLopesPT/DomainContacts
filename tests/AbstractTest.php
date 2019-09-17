<?php
namespace NunoLopes\Tests\DomainContacts;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest.
 *
 * This class will add extra functionality to all tests.
 * This should be extended by all tests instead of TestCase.
 *
 * @package NunoLopes\DomainContacts
 */
abstract class AbstractTest extends TestCase
{
    /**
     * @var Generator $faker - Faker instance to generate random values.
     */
    protected $faker = null;

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function setUp(): void
    {
        // Call parent function.
        parent::setUp();

        $this->faker = Factory::create();
    }
}
