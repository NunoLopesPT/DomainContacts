<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Services;

use NunoLopes\DomainContacts\Contracts\Utilities\RsaSignature;
use NunoLopes\DomainContacts\Datatypes\AsymmetricCryptography;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Services\AuthenticationToken\JwtAuthenticationTokenService;
use NunoLopes\Tests\DomainContacts\AbstractTest;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class AccessTokenServiceTest.
 *
 * @covers \NunoLopes\DomainContacts\Services\AuthenticationToken\JwtAuthenticationTokenService
 *
 * @package NunoLopes\DomainContacts
 */
class JwtAuthenticationTokenServiceTest extends AbstractTest
{
    /**
     * @var MockObject|RsaSignature $signature - AccessToken Repository Mocked Instance.
     */
    private $signature = null;

    /**
     * @var JwtAuthenticationTokenService $service - JWT Authentication Token Service Instance.
     */
    private $service = null;

    /**
     * @var MockObject|AsymmetricCryptography $crypt - Asymmetric Cryptography Mocked instance.
     */
    private $crypt = null;

    /**
     * @var string $token - Token that will be used among tests.
     */
    private static $token = null;

    /**
     * @var string $tokenId - AccessToken ID of the Authentication Token.
     */
    private $tokenId = "DummyTokenID";

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent function.
        parent::setUp();

        // Mock dependencies.
        $this->signature = $this->createMock(RsaSignature::class);
        $this->crypt     = $this->createMock(AsymmetricCryptography::class);

        // Instantiates Service.
        $this->service = new JwtAuthenticationTokenService($this->signature, $this->crypt);
    }

    /**
     * Test that a JWT Authentication token can be created.
     *
     * @return void
     */
    public function testCanCreateJwtAuthenticationToken(): void
    {
        // Mocks AccessToken Entity.
        $accessToken = $this->createMock(AccessToken::class);
        $accessToken->expects($this->once())
                    ->method('tokenId')
                    ->willReturn($this->tokenId);
        $accessToken->expects($this->once())
                    ->method('createdAt')
                    ->willReturn($this->faker->dateTime->format("Y-m-d H:i:s"));
        $accessToken->expects($this->once())
                    ->method('expiresAt')
                    ->willReturn($this->faker->dateTime->format("Y-m-d H:i:s"));

        // Mocks Signature.
        $this->signature
             ->expects($this->once())
             ->method('sign')
             ->willReturn('signatureString');

        // Performs test.
        $result = $this->service->create($accessToken);

        $this->assertStringMatchesFormat(
            "%s.%s.%s",
            $result
        );

        // Save the created token so it can be used in the next tests.
        self::$token = $result;
    }

    /**
     * Tests that a JWT token can be decoded.
     *
     * @depends testCanCreateJwtAuthenticationToken
     *
     * @return void
     */
    public function testCanDecodeJwtAuthenticationToken(): void
    {
        // Mocks Signature.
        $this->signature
             ->expects($this->once())
             ->method('verify')
             ->willReturn(true);

        // Performs test.
        $result = $this->service->accessTokenId(self::$token);

        // Performs assertions.
        $this->assertEquals(
            $this->tokenId,
            $result
        );
    }
}
