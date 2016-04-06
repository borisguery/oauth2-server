<?php

namespace Bgy\OAuth2\Storage;

use Bgy\OAuth2\RefreshToken;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
interface RefreshTokenStorage
{
    public function save(RefreshToken $refreshToken);
    public function delete(RefreshToken $refreshToken);

    /**
     * @return RefreshToken
     * @throws RefreshTokenNotFound
     */
    public function findByToken($token);
}
