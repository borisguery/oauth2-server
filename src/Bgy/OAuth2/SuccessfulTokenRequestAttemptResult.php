<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\GrantType\GrantDecision;

class SuccessfulTokenRequestAttemptResult implements TokenRequestAttemptResult
{
    private $grantDecision;
    private $accessToken;
    private $refreshToken;

    public function __construct(GrantDecision $grantDecision, AccessToken $accessToken,
                                RefreshToken $refreshToken = null)
    {
        if ($grantDecision->isDenied()) {
            throw new \LogicException('Could not construct SuccessfulTokenRequestResult with a denied GrantDecision');
        }

        $this->grantDecision = $grantDecision;
        $this->accessToken   = $accessToken;
        $this->refreshToken  = $refreshToken;
    }

    public function getGrantDecision()
    {
        return $this->grantDecision;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }
}
