<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Datatypes\AuthenticationToken;

use NunoLopes\DomainContacts\Contracts\Utilities\RsaSignature;
use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;
use NunoLopes\DomainContacts\Datatypes\AuthenticationToken\JsonWebToken;
use NunoLopes\Tests\DomainContacts\AbstractTest;

/**
 * Class JsonWebTokenTest
 *
 * @package NunoLopes\DomainContacts
 */
class JsonWebTokenTest extends AbstractTest
{
    /**
     * @var JsonWebToken $JWT
     */
    private static $JWT = null;

    /**
     * Test JWT can be created.
     *
     * @return void
     */
    public function testJwtCanBeEncoded(): void
    {
        // Creates JWT.
        $jwt = new JsonWebToken();
        $jwt->payload()
            ->id('dummyId')
            ->expiration($this->faker->dateTimeBetween('+10 days', '+20 days')->getTimestamp());

        // Mocks RSA Signature.
        $signature = $this->createMock(RsaSignature::class);
        $signature->expects($this->once())
                  ->method('code')
                  ->willReturn('DummyCode');
        $signature->expects($this->once())
                  ->method('sign')
                  ->willReturn('DummySignature');

        // Mocks Asymmetric Cryptography instance.
        $crypt = $this->createMock(AsymmetricCryptography::class);

        // Sign the JWT token.
        $jwt->sign(
            $signature,
            $crypt
        );

        // Performs test.
        $result = $jwt->encode();

        // Performs assertion.
        $this->assertIsString(
            $result
        );
        $this->assertStringMatchesFormat(
            "%s.%s.%s",
            $result
        );

        // Saves token to be executed in dependant tests.
        self::$JWT = $jwt;
    }

    /**
     * Test JWT can be decoded.
     *
     * @depends testJwtCanBeEncoded
     *
     * @return void
     */
    public function testJwtCanBeDecoded(): void
    {
        // Create a new Token.
        $jwt = new JsonWebToken();

        // Encode the previous token and try to decode it.
        $jwt->decode(self::$JWT->encode());

        // Mocks RSA Signature.
        $signature = $this->createMock(RsaSignature::class);
        $signature->expects($this->once())
                  ->method('code')
                  ->willReturn('DummyCode');
        $signature->expects($this->once())
                  ->method('verify')
                  ->willReturn(true);

        // Mocks Asymmetric Cryptography instance.
        $crypt = $this->createMock(AsymmetricCryptography::class);

        // Performs test.
        $jwt->verify($signature, $crypt);

        // Performs assertion
        // AssertEquals will check if every single attribute is equal.
        $this->assertEquals(
            $jwt,
            self::$JWT
        );
    }

    /**
     * Test cannot verify token if the Signature Code is different from the JWT.
     *
     * @depends testJwtCanBeEncoded
     *
     * @return void
     */
    public function testCannotVerifyTokenIfSignatureCodeIsDifferent(): void
    {
        // Creates expectation.
        $this->expectException(\UnexpectedValueException::class);

        // Mocks RSA Signature.
        $signature = $this->createMock(RsaSignature::class);
        $signature->expects($this->once())
                  ->method('code')
                  ->willReturn('AnotherDummyCode');

        // Mocks Asymmetric Cryptography instance.
        $crypt = $this->createMock(AsymmetricCryptography::class);

        self::$JWT->verify($signature, $crypt);
    }

    /**
     * Test cannot decode token that is empty.
     *
     * @return void
     */
    public function testCannotDecodeTokenThatIsEmpty(): void
    {
        // Creates expectation
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        $jwt = new JsonWebToken();
        $jwt->decode('  ');
    }

    /**
     * Test cannot decode token that is not valid.
     *
     * @return void
     */
    public function testCannotDecodeTokenThatIsNotValid(): void
    {
        // Creates expectation.
        $this->expectException(\InvalidArgumentException::class);

        // Performs test.
        $jwt = new JsonWebToken();
        $jwt->decode('InvalidToken');
    }

    /**
     * Test cannot encode a JWT that has no signature.
     *
     * @return void
     */
    public function testCannotEncodeTokenThatHasNoSignature(): void
    {
        // Creates expectation.
        $this->expectException(\UnexpectedValueException::class);

        // Pre Requisites.
        $jwt = new JsonWebToken();
        $jwt->payload()
            ->id('randomId')
            ->expiration($this->faker->unixTime());

        // Performs test.
        $jwt->encode();
    }
}
