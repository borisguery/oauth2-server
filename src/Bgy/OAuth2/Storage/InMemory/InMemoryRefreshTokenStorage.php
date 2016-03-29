<?php

namespace Bgy\OAuth2\Storage\InMemory;

use Bgy\OAuth2\RefreshToken;
use Bgy\OAuth2\Storage\RefreshTokenNotFound;
use Bgy\OAuth2\Storage\RefreshTokenStorage;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class InMemoryRefreshTokenStorage implements RefreshTokenStorage
{
    private $refreshTokens = [];

    public function save(RefreshToken $refreshToken)
    {
        $this->refreshTokens[$refreshToken->getToken()] = $refreshToken;
    }

    public function delete(RefreshToken $refreshToken)
    {
        if (!isset($this->refreshTokens[$refreshToken->getToken()])) {

            throw new RefreshTokenNotFound($refreshToken->getToken());
        }

        unset($this->refreshTokens[$refreshToken->getToken()]);
    }

    public function findByToken($refreshTokenId)
    {
        if (!isset($this->refreshTokens[$refreshTokenId])) {

            throw new RefreshTokenNotFound($refreshTokenId);
        }
    }
}
