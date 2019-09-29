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

    /**
     * Test hash fails if string is empty.
     *
     * @return void
     */
    public function testHashFailsIfStringIsEmpty(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        Hash::create('');
    }

    /**
     * Test hash verification fails if string is empty.
     *
     * @return void
     */
    public function testHashVerificationFailsIfStringIsEmpty(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        Hash::verify('', 'hash');
    }

    /**
     * Test hash verification fails if hash is empty.
     *
     * @return void
     */
    public function testHashVerificationFailsIfHashIsEmpty(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        Hash::verify('string', '');
    }
}
