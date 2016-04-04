<?php

namespace Bgy\OAuth2;

use Bgy\OAuth2\Utils\Ensure;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class AccessToken
{
    private $accessToken;
    private $expiresAt;
    private $clientId;
    private $resourceOwnerId;
    private $scopes;

    public function __construct($token, \DateTimeImmutable $expiresAt, $clientId, ResourceOwner $resourceOwnerId = null, array $scopes = [])
    {
        Ensure::string($token);

        $this->accessToken     = $token;
        $this->expiresAt       = $expiresAt;
        $this->clientId        = $clientId;
        $this->resourceOwnerId = $resourceOwnerId;
        $this->scopes          = $scopes;
    }

    public function getToken()
    {
        return $this->accessToken;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
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
