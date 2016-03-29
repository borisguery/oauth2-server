<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;

class UnsupportedGrantType extends \InvalidArgumentException
{
    public function __construct($grantTypeClassName, $grantTypeIdentifier, $requestedGrantType)
    {
        parent::__construct(sprintf(
            'A token request attempt has been made but the current grant type (identified by "%s") doesn\'t support it (requested grant type: "%s"',
            $grantTypeIdentifier,
            $requestedGrantType
        ));
    }
}
