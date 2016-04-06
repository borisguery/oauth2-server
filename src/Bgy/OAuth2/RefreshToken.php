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
    private $revokedAt;

    public function __construct($token, AccessToken $associatedAccessToken,
                                \DateTimeImmutable $expiresAt,
                                \DateTimeImmutable $revokedAt = null)
    {
        $this->token                 = $token;
        $this->associatedAccessToken = $associatedAccessToken;
        $this->expiresAt             = $expiresAt;
        $this->revokedAt             = $revokedAt;
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

    public function revoke()
    {
        $this->revokedAt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public function getRevokedAt()
    {
        return $this->revokedAt;
    }

    public function isRevoked()
    {
        return (null !== $this->revokedAt);
    }
}
