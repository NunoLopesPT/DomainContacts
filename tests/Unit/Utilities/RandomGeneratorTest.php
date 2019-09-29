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
    public function testRandomHashIsNeverEqual(): void
    {
        $string1 = RandomGenerator::string();
        $string2 = RandomGenerator::string();

        $this->assertNotEquals(
            $string1,
            $string2,
            'The strings should not be the same.'
        );
    }
}
