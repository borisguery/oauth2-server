<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\GrantType\GrantDecision;

interface TokenRequestAttemptResult
{
    /**
     * @return GrantDecision
     */
    public function getGrantDecision();
}
