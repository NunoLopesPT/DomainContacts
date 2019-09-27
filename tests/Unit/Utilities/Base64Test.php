<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Utilities;

use NunoLopes\DomainContacts\Utilities\Base64;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class Base64Test.
 *
 * The aim of this class is to test the Base64 Utility.
 *
 * @todo Check that the encoded string is a Base64 URL.
 *
 * @package NunoLopes\DomainContacts
 */
class Base64Test extends AbstractTest
{
    /**
     * Test that a Base64 URL can be encoded and decoded.
     *
     * @return void
     */
    public function testCanEncodeAndDecodeBase64URL(): void
    {
        // Generates a random string.
        $string = $this->faker->password;

        // Creates an hash.
        $data = Base64::urlEncode($string);

        // Assert the string is different.
        $this->assertNotEquals(
            $string,
            $data,
            'The string should be different.'
        );

        // Performs test.
        $result = Base64::urlDecode($data);

        // Performs assertions.
        $this->assertEquals(
            $result,
            $string,
            'The verification should have returned true.'
        );
    }
}
