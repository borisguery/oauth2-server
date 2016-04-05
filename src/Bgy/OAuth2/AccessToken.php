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
    private $resourceOwner;
    private $scopes;

    public function __construct($token, \DateTimeImmutable $expiresAt, $clientId, ResourceOwner $resourceOwner = null, array $scopes = [])
    {
        Ensure::string($token);

        $this->accessToken     = $token;
        $this->expiresAt       = $expiresAt;
        $this->clientId        = $clientId;
        $this->resourceOwner   = $resourceOwner;
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

    public function getResourceOwner()
    {
        return $this->resourceOwner;
    }

    public function isExpired()
    {
        return ($this->expiresAt < new \DateTime('now', new \DateTimeZone('UTC')));
    }
}
