<?php

namespace Bgy\OAuth2\Storage;

use Bgy\OAuth2\RefreshToken;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
interface RefreshTokenStorage
{
    public function save(RefreshToken $accessToken);
    public function delete(RefreshToken $accessToken);

    /**
     * @return RefreshToken
     * @throws RefreshTokenNotFound
     */
    public function findByToken($token);
}
