<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\GrantType\GrantDecision;

class FailedTokenRequestAttemptResult implements TokenRequestAttemptResult
{
    private $grantDecision;

    public function __construct(GrantDecision $grantDecision)
    {
        if ($grantDecision->isDenied()) {
            throw new \LogicException('Could not construct FailedTokenRequestResult with a allowed GrantDecision');
        }

        $this->grantDecision = $grantDecision;
    }

    public function getGrantDecision()
    {
        return $this->grantDecision;
    }
}
