<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Datatypes\AuthenticationToken\JsonWebToken;

use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class JwtHeaderTest.
 *
 * @package NunoLopes\Tests\DomainContacts
 */
class JwtHeaderTest extends AbstractTest
{
    /**
     * @var JsonWebToken\JwtHeader $header - JWT Header instance.
     */
    private static $header;

    /**
     * Test JWT can be created.
     *
     * @return void
     */
    public function testCanEncodeJwtHeader(): void
    {
        // Creates JWT.
        $header = new JsonWebToken\JwtHeader();

        // Performs test.
        $header->algorithm('DummyAlgorithm');

        // Performs assertion.
        $this->assertEquals(
            'DummyAlgorithm',
            $header->getAlgorithm()
        );

        self::$header = $header;
    }

    /**
     * Test can decode JWT Header.
     *
     * @depends testCanEncodeJwtHeader
     *
     * @return void
     */
    public function testCanDecodeJwtHeader(): void
    {
        // Creates JWT.
        $header = new JsonWebToken\JwtHeader();

        // Performs test.
        $header->decode(self::$header->encoded());

        // Performs assertions.
        $this->assertEquals(
            self::$header,
            $header
        );
    }
}
