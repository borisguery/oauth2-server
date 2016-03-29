<?php

namespace Bgy\OAuth2;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class RefreshToken
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }
}
