<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\Storage\ClientStorage;
use Bgy\OAuth2\Storage\AccessTokenStorage;
use Bgy\OAuth2\Storage\RefreshTokenStorage;

class ResourceServerConfiguration
{
    private $clientStorage;
    private $accessTokenStorage;
    private $refreshTokenStorage;
    private $tokenGenerator;
    private $options = [
        'always_require_a_client'  => false,
        'access_token_ttl'         => 3600,
        'access_token_length'      => 32,
    ];

    private $grantTypes = [];

    public function __construct(ClientStorage $clientStorage, AccessTokenStorage $accessTokenStorage,
                                RefreshTokenStorage $refreshTokenStorage, array $grantTypes,
                                TokenGenerator $tokenGenerator,
                                array $options = [])
    {
        $this->clientStorage        = $clientStorage;
        $this->accessTokenStorage   = $accessTokenStorage;
        $this->refreshTokenStorage  = $refreshTokenStorage;
        $this->grantTypes           = $grantTypes;
        $this->tokenGenerator       = $tokenGenerator;
        $this->options              = array_merge($this->options, $options);
    }

    public function getClientStorage()
    {
        return $this->clientStorage;
    }

    public function getAccessTokenStorage()
    {
        return $this->accessTokenStorage;
    }

    public function getRefreshTokenStorage()
    {
        return $this->refreshTokenStorage;
    }

    public function getGrantTypeExtensions()
    {
        return $this->grantTypes;
    }

    public function alwaysRequireAClient()
    {
        return $this->options['always_require_a_client'];
    }

    public function alwaysGenerateARefreshToken()
    {
        return $this->options['always_generate_a_refresh_token'];
    }

    public function getAccessTokenTTL()
    {
        return $this->options['access_token_ttl'];
    }

    public function getTokenGenerator()
    {
        return $this->tokenGenerator;
    }

    public function getAccessTokenLength()
    {
        return $this->options['access_token_length'];
    }
}
