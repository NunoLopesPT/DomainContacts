<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Utilities;

use NunoLopes\DomainContacts\Utilities\Hash;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class HashTest.
 *
 * The aim of this class is to test the Hash Utility.
 *
 * @package NunoLopes\DomainContacts
 */
class HashTest extends AbstractTest
{
    /**
     * Test that an Hash can be created and verified.
     *
     * @return void
     */
    public function testCanHashAndVerifyString(): void
    {
        // Generates a random string.
        $string = $this->faker->password;

        // Creates an hash.
        $hash = Hash::create($string);

        // Assert the string is different.
        $this->assertNotEquals(
            $string,
            $hash,
            'The string should be different.'
        );

        // Performs test.
        $result = Hash::verify($string, $hash);

        // Performs assertions.
        $this->assertTrue(
            $result,
            'The verification should have returned true.'
        );
    }
}