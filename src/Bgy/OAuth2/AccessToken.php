<?php

namespace Bgy\OAuth2;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class AccessToken
{
    private $accessToken;
    private $expiresIn;
    private $clientId;
    private $resourceOwnerId;
    private $tokenType;
    private $scopes;

    public function __construct($token, $expiresIn, $clientId, $resourceOwnerId, $tokenType, array $scopes = [])
    {
        $this->accessToken     = $token;
        $this->expiresIn       = $expiresIn;
        $this->clientId        = $clientId;
        $this->resourceOwnerId = $resourceOwnerId;
        $this->scopes          = $scopes;
        $this->tokenType       = $tokenType;
    }

    public function getToken()
    {
        return $this->accessToken;
    }

    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    public function getScopes()
    {
        return $this->scopes;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }
}
