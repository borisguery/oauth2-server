<?php

namespace Bgy\OAuth2\Storage;

use Bgy\OAuth2\AccessToken;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
interface AccessTokenStorage
{
    public function save(AccessToken $accessToken);
    public function delete(AccessToken $accessToken);

    /**
     * @return AccessToken
     * @throws AccessTokenNotFound
     */
    public function findByToken($token);
}
