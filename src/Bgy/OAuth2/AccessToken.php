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
    private $scopes;

    public function __construct($token, $expiresIn, $clientId, $resourceOwnerId, array $scopes = [])
    {
        $this->accessToken     = $token;
        $this->expiresIn       = $expiresIn;
        $this->clientId        = $clientId;
        $this->resourceOwnerId = $resourceOwnerId;
        $this->scopes          = $scopes;
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
}
