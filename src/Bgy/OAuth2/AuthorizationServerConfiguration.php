<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\GrantType\GrantType;
use Bgy\OAuth2\Storage\ClientStorage;
use Bgy\OAuth2\Storage\AccessTokenStorage;
use Bgy\OAuth2\Storage\RefreshTokenStorage;

class AuthorizationServerConfiguration
{
    private $tokenGenerator;
    private $options = [
        'always_require_a_client'        => false,
        'access_token_ttl'               => 3600,
        'refresh_token_ttl'              => 3600,
        'access_token_length'            => 32,
        'revoke_refresh_token_when_used' => true,
    ];

    public function __construct(TokenGenerator $tokenGenerator, array $options = [])
    {
        $this->tokenGenerator       = $tokenGenerator;
        $this->options              = array_merge($this->options, $options);
    }

    public function alwaysRequireAClient()
    {
        return $this->options['always_require_a_client'];
    }

    public function alwaysGenerateARefreshToken()
    {
        return $this->options['always_generate_a_refresh_token'];
    }

    public function shouldRevokeRefreshTokenWhenUsed()
    {
        return $this->options['revoke_refresh_token_when_used'];
    }

    public function getAccessTokenTTL()
    {
        return $this->options['access_token_ttl'];
    }

    public function getRefreshTokenTTL()
    {
        return $this->options['refresh_token_ttl'];
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
