<?php

namespace Bgy\OAuth2\Storage\InMemory;

use Bgy\OAuth2\AccessToken;
use Bgy\OAuth2\Storage\AccessTokenNotFound;
use Bgy\OAuth2\Storage\AccessTokenStorage;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class InMemoryAccessTokenStorage implements AccessTokenStorage
{
    private $accessTokens = [];

    public function save(AccessToken $accessToken)
    {
        $this->accessTokens[$accessToken->getToken()] = $accessToken;
    }

    public function delete(AccessToken $accessToken)
    {
        if (!isset($this->accessTokens[$accessToken->getToken()])) {

            throw new AccessTokenNotFound($accessToken->getToken());
        }

        unset($this->accessTokens[$accessToken->getToken()]);
    }

    public function findByToken($accessTokenId)
    {
        if (!isset($this->accessTokens[$accessTokenId])) {

            throw new AccessTokenNotFound($accessTokenId);
        }
    }
}
