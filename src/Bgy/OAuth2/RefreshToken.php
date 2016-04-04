<?php

namespace Bgy\OAuth2;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class RefreshToken
{
    private $token;
    private $associatedAccessToken;

    public function __construct($token, AccessToken $associatedAccessToken)
    {
        $this->token                 = $token;
        $this->associatedAccessToken = $associatedAccessToken;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getAssociatedAccessToken()
    {
        return $this->associatedAccessToken;
    }
}
