<?php

namespace Bgy\OAuth2\GrantType;

use Bgy\OAuth2\TokenRequestAttempt;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

interface GrantType
{
    /**
     * @param TokenRequestAttempt $tokenRequestAttempt
     *
     * @return GrantDecision
     *
     * @throws MissingOrInvalidInputData
     * @throws UnsupportedGrantType
     */
    public function grant(TokenRequestAttempt $tokenRequestAttempt);

    public function getIdentifier();

    /**
     * @return array
     */
    public function getRequiredInputData();
}
