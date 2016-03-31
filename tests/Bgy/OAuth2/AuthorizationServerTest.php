<?php

namespace Bgy\OAuth2;

use Bgy\OAuth2\GrantType\ClientCredentialsGrantType;
use Bgy\OAuth2\GrantType\GrantError;
use Bgy\OAuth2\Storage\AccessTokenStorage;
use Bgy\OAuth2\Storage\ClientStorage;
use Bgy\OAuth2\Storage\RefreshTokenStorage;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class AuthorizationServerTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthorizationServerWithoutAnyGrantTypesShouldReturnAFailedAttemptResult()
    {
        $client = new Client('client_test_id', 'secret', [], []);

        $clientStorage = $this->getMockBuilder(ClientStorage::class)
            ->getMock()
        ;
        $clientStorage
            ->expects($this->any())
            ->method('findById')
            ->with('client_test_id')
            ->willReturn($client)
        ;

        $accessTokenStorage = $this->getMockBuilder(AccessTokenStorage::class)
            ->getMock()
        ;

        $accessToken = new AccessToken('access_token_test', 3600, $client->getId(), 'borisguery');

        $accessTokenStorage
            ->expects($this->any())
            ->method('findByToken')
            ->with($accessToken->getToken())
            ->willReturn($accessToken->getToken())
        ;

        $refreshTokenStorage = $this->getMockBuilder(RefreshTokenStorage::class)
            ->getMock()
        ;

        $refreshToken = new RefreshToken('refresh_token_test');

        $refreshTokenStorage
            ->expects($this->any())
            ->method('findByToken')
            ->with($refreshToken->getToken())
            ->willReturn($refreshToken->getToken())
        ;

        $tokenGenerator = $this->getMockBuilder(TokenGenerator::class)
            ->getMock()
        ;

        $tokenGenerator->expects($this->any())
            ->method('generate')
            ->willReturn($accessToken->getToken())
        ;

        $configuration = (new AuthorizationServerConfigurationBuilder())
            ->setAccessTokenStorage($accessTokenStorage)
            ->setClientStorage($clientStorage)
            ->setRefreshStorage($refreshTokenStorage)
            ->setAccessTokenGenerator($tokenGenerator)
            ->alwaysRequireAClient(true)
            ->alwaysGenerateARefreshToken(true)
            ->build()
            ->getAuthorizationServerConfiguration()
        ;

        $resourceServer = new AuthorizationServer($configuration);

        $inputDataBag = new InputDataBag([
            'grant_type'    => 'client_credentials',
            'client_id'     => 'test',
            'client_secret' => 'secret'
        ]);

        $attemptResult = $resourceServer->requestAccessToken(
            new TokenRequestAttempt($inputDataBag->getGrantType(), $inputDataBag)
        );

        $this->assertInstanceOf(FailedTokenRequestAttemptResult::class, $attemptResult);
        $this->assertTrue($attemptResult->getGrantDecision()->isDenied());
        $this->assertEquals(
            GrantError::INVALID_GRANT,
            $attemptResult->getGrantDecision()->getError()->getError()
        );
    }

    public function testAuthorizationServerWithClientCredentialsGrantType()
    {
        $client = new Client('client_test_id', 'secret', [], ['client_credentials']);

        $clientStorage = $this->getMockBuilder(ClientStorage::class)
            ->getMock()
        ;
        $clientStorage
            ->expects($this->any())
            ->method('findById')
            ->with('client_test_id')
            ->willReturn($client)
        ;

        $accessTokenStorage = $this->getMockBuilder(AccessTokenStorage::class)
            ->getMock()
        ;

        $accessToken = new AccessToken('access_token_test', 3600, $client->getId(), 'borisguery');

        $accessTokenStorage
            ->expects($this->any())
            ->method('findByToken')
            ->with($accessToken->getToken())
            ->willReturn($accessToken->getToken())
        ;

        $refreshTokenStorage = $this->getMockBuilder(RefreshTokenStorage::class)
            ->getMock()
        ;

        $refreshToken = new RefreshToken('refresh_token_test');

        $refreshTokenStorage
            ->expects($this->any())
            ->method('findByToken')
            ->with($refreshToken->getToken())
            ->willReturn($refreshToken->getToken())
        ;

        $tokenGenerator = $this->getMockBuilder(TokenGenerator::class)
            ->getMock()
        ;

        $tokenGenerator->expects($this->any())
            ->method('generate')
            ->willReturn($accessToken->getToken())
        ;

        $configuration = (new AuthorizationServerConfigurationBuilder())
            ->setAccessTokenStorage($accessTokenStorage)
            ->setClientStorage($clientStorage)
            ->setRefreshStorage($refreshTokenStorage)
            ->setAccessTokenGenerator($tokenGenerator)
            ->alwaysRequireAClient(true)
            ->alwaysGenerateARefreshToken(true)
            ->addGrantType(new ClientCredentialsGrantType(new ClientAuthenticator($clientStorage)))
            ->build()
            ->getAuthorizationServerConfiguration()
        ;

        $resourceServer = new AuthorizationServer($configuration);

        $inputDataBag = new InputDataBag([
            'grant_type'    => 'client_credentials',
            'client_id'     => 'client_test_id',
            'client_secret' => 'secret'
        ]);

        $attemptResult = $resourceServer->requestAccessToken(
            new TokenRequestAttempt($inputDataBag->getGrantType(), $inputDataBag)
        );

        $this->assertInstanceOf(SuccessfulTokenRequestAttemptResult::class, $attemptResult);
        $this->assertTrue($attemptResult->getGrantDecision()->isAllowed());
        $this->assertEquals(
            GrantError::NONE,
            $attemptResult->getGrantDecision()->getError()->getError()
        );
    }
}
