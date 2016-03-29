<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;

use Bgy\OAuth2\TokenRequestAttempt;

class PasswordGrantType implements GrantType
{
    public function grant(TokenRequestAttempt $tokenRequestAttempt)
    {

    }

    public function getRequiredInputData()
    {
        return [
            'username',
            'password',
        ];
    }

    public function getIdentifier()
    {
        return 'password';
    }
}
