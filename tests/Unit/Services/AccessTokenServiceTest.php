<?php
namespace NunoLopes\Tests\DomainContacts\Unit\Services;

use NunoLopes\DomainContacts\Contracts\Repositories\Database\AccessTokenRepository;
use NunoLopes\DomainContacts\Contracts\Services\AuthenticationTokenService;
use NunoLopes\DomainContacts\Entities\AccessToken;
use NunoLopes\DomainContacts\Entities\User;
use NunoLopes\DomainContacts\Exceptions\Services\AccessToken\UserHasNoIdException;
use NunoLopes\DomainContacts\Exceptions\Services\Authentication\TokenRevokedException;
use NunoLopes\DomainContacts\Services\AccessTokenService;
use NunoLopes\Tests\DomainContacts\AbstractTest;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class AccessTokenServiceTest.
 *
 * @package NunoLopes\DomainContacts
 */
class AccessTokenServiceTest extends AbstractTest
{
    /**
     * @var MockObject|AccessTokenRepository $accessToken - AccessToken Repository Mocked Instance.
     */
    private $accessToken = null;

    /**
     * @var MockObject|AuthenticationTokenService $authToken - Authentication Token Service Mocked Instance.
     */
    private $authToken = null;

    /**
     * @var AccessTokenService $service - Authentication Service Instance.
     */
    private $service = null;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        // Calls parent function.
        parent::setUp();

        // Mock dependencies.
        $this->accessToken = $this->createMock(AccessTokenRepository::class);
        $this->authToken   = $this->createMock(AuthenticationTokenService::class);

        // Instantiates Service.
        $this->service = new AccessTokenService($this->accessToken, $this->authToken);
    }

    /**
     * Test that an AccessToken can be created.
     *
     * @return void
     */
    public function testCanCreateAccessToken(): void
    {
        // Mock User that a token is going to be created for.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('hasId')
             ->willReturn(true);
        $user->expects($this->once())
             ->method('id')
             ->willReturn(1);

        // Performs test.
        $result = $this->service->createToken($user);

        $this->assertIsString(
            $result,
            'The result should be a token.'
        );
    }

    /**
     * Test that an AccessToken cannot be created if the User entity has no ID.
     *
     * @return void
     */
    public function testAccessTokenCannotBeCreatedIfUserHasNoId(): void
    {
        // Creates expectation.
        $this->expectException(UserHasNoIdException::class);

        // Mock User that a token is going to be created for.
        $user = $this->createMock(User::class);
        $user->expects($this->once())
             ->method('hasId')
             ->willReturn(false);

        // Performs test.
        $this->service->createToken($user);
    }

    /**
     * Test that an AccessToken can be created.
     *
     * @return void
     */
    public function testCanGetAccessToken(): void
    {
        // Mocks AccessToken Repository.
        $accessToken = $this->createMock(AccessToken::class);

        // Mocks Authentication Token Service.
        $this->authToken
            ->expects($this->once())
            ->method('accessTokenId')
            ->with('dummyAuthenticationToken')
            ->willReturn('dummyAccessTokenId');
        $this->accessToken
            ->expects($this->once())
            ->method('getByToken')
            ->with('dummyAccessTokenId')
            ->willReturn($accessToken);

        // Performs test.
        $result = $this->service->getAccessToken('dummyAuthenticationToken');

        // Performs assertions.
        $this->assertInstanceOf(
            AccessToken::class,
            $result
        );
    }

    /**
     * Test that an exception is raised if the AccessToken is Revoked.
     *
     * @return void
     */
    public function testCannotGetAccessIfTokenIsRevoked(): void
    {
        // Creates expectation.
        $this->expectException(TokenRevokedException::class);

        // Mocks AccessToken Repository.
        $accessToken = $this->createMock(AccessToken::class);
        $accessToken->expects($this->once())
                    ->method('revoked')
                    ->willReturn(true);

        // Mocks Authentication Token Service.
        $this->authToken
             ->expects($this->once())
             ->method('accessTokenId')
             ->willReturn('dummyAccessTokenId');
        $this->accessToken
             ->expects($this->once())
             ->method('getByToken')
             ->willReturn($accessToken);

        // Performs test.
        $this->service->getTokenUser('dummyAuthenticationToken');
    }

    /**
     * Test can revoke a Token.
     *
     * @return void
     */
    public function testCanRevokeAToken(): void
    {
        // Mocks the access token that is going to be revoked.
        $accessToken = $this->createMock(AccessToken::class);

        // Mocks AccessToken Repository.
        $this->accessToken
             ->expects($this->once())
             ->method('revoke')
             ->with($accessToken)
             ->willReturn(true);

        // Performs test.
        $this->service->revokeToken($accessToken);
    }
}
