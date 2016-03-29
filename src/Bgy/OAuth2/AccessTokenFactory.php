<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;


class AccessTokenFactory
{
    private $generator;

    public function __construct(AccessTokenGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function createAccessToken($expiresIn, $clientId, $resourceOwnerId, array $scopes = [])
    {
        return new AccessToken(
            $this->generator->generate(),
            $expiresIn,
            $clientId,
            $resourceOwnerId,
            $scopes
        );
    }
}
