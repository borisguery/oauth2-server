<?php

namespace Bgy\OAuth2;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class RefreshToken
{
    private $token;
    private $associatedAccessToken;
    private $expiresAt;

    public function __construct($token, AccessToken $associatedAccessToken, \DateTimeImmutable $expiresAt)
    {
        $this->token                 = $token;
        $this->associatedAccessToken = $associatedAccessToken;
        $this->expiresAt             = $expiresAt;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getAssociatedAccessToken()
    {
        return $this->associatedAccessToken;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
}
