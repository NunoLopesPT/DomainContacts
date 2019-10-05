<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Datatypes\AuthenticationToken\JsonWebToken;

use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class JwtPayloadTest.
 *
 * @package NunoLopes\Tests\DomainContacts
 */
class JwtPayloadTest extends AbstractTest
{
    /**
     * @var JsonWebToken\JwtPayload $payload - JWT Payload instance.
     */
    private static $payload;

    /**
     * Test JWT Payload can be created.
     *
     * @return void
     */
    public function testCanEncodeJwtPayload(): void
    {
        // Attributes of the JWT Payload.
        $attributes = [
            'id'         => 'DummyId',
            'expiration' => $this->faker->unixTime,
            'subject'    => $this->faker->name,
            'issuedAt'   => $this->faker->unixTime,
            'audience'   => ['1'],
            'issuer'     => $this->faker->name,
            'notBefore'  => $this->faker->unixTime,
        ];

        // Creates JWT Payload.
        $payload = new JsonWebToken\JwtPayload();
        $payload->expiration($attributes['expiration'])
                ->id($attributes['id'])
                ->subject($attributes['subject'])
                ->issuedAt($attributes['issuedAt'])
                ->audience($attributes['audience'])
                ->issuer($attributes['issuer'])
                ->notBefore($attributes['notBefore']);

        // Performs assertions.
        $this->assertEquals(
            $attributes['id'],
            $payload->getId()
        );
        $this->assertEquals(
            $attributes['expiration'],
            $payload->getExpiration()
        );
        $this->assertEquals(
            $attributes['subject'],
            $payload->getSubject()
        );
        $this->assertEquals(
            $attributes['issuedAt'],
            $payload->getIssuedAt()
        );
        $this->assertEquals(
            $attributes['audience'],
            $payload->getAudience()
        );
        $this->assertEquals(
            $attributes['issuer'],
            $payload->getIssuer()
        );
        $this->assertEquals(
            $attributes['notBefore'],
            $payload->getNotBefore()
        );
        $this->assertIsString(
            $payload->encoded()
        );

        self::$payload = $payload;
    }

    /**
     * Test can decode JWT Payload.
     *
     * @depends testCanEncodeJwtPayload
     *
     * @return void
     */
    public function testCanDecodeJwtPayload(): void
    {
        // Creates JWT.
        $payload = new JsonWebToken\JwtPayload();

        // Performs test.
        $payload->decode(self::$payload->encoded());

        // Performs assertions.
        $this->assertEquals(
            self::$payload,
            $payload
        );
    }

    /**
     * Test JWT Header cannot be encoded if there is no algorithm.
     *
     * @return void
     */
    public function testCannotEncodeJwtPayloadIfNoAlgIsSet(): void
    {
        // Creates expectation.
        $this->expectException(\UnexpectedValueException::class);

        // Creates JWT Header.
        $payload = new JsonWebToken\JwtPayload();

        // Performs test.
        $payload->encoded();
    }
}
