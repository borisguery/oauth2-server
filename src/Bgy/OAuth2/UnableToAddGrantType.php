<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

class UnableToAddGrantType extends \LogicException implements Exception
{
    public static function aGrantTypeExtensionIsAlreadyRegisteredForThisIdentifier($identifier, $registeredClassName)
    {
        return new self(
            sprintf(
                'A Grant Type Extension is already registered for this identifier: "%s" (%s)',
                $identifier,
                $registeredClassName
            )
        );
    }
}
