<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Utilities;

use NunoLopes\DomainContacts\Utilities\RandomGenerator;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class RandomGeneratorTest.
 *
 * @package NunoLopes\DomainContacts
 */
class RandomGeneratorTest extends AbstractTest
{
    /**
     * Test that the generated strings are never equal.
     *
     * @return void
     */
    public function testRandomStringIsNeverEqual(): void
    {
        $string1 = RandomGenerator::string();
        $string2 = RandomGenerator::string();

        $this->assertNotEquals(
            $string1,
            $string2,
            'The strings should not be the same.'
        );
    }

    /**
     * Test cannot generate a random string if the length given is negative.
     *
     * @return void
     */
    public function testRandomStringFailsIfLenghtGivenIsNegative(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        RandomGenerator::string(-1);
    }

    /**
     * Test cannot generate a random string if the length given is zero.
     *
     * @return void
     */
    public function testRandomStringFailsIfLenghtGivenIsZero(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        RandomGenerator::string(0);
    }
}
