<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\Utils;

use Assert\Assertion;

class Ensure extends Assertion
{
    public static function positiveIntegerOrZero($value, $message = null, $propertyPath = null)
    {
        \Assert\that($value, $message, $propertyPath)
            ->integer()
            ->min(0)
        ;
    }

    public static function positiveInteger($value, $message = null, $propertyPath = null)
    {
        \Assert\that($value, $message, $propertyPath)
            ->integer()
            ->min(1);
    }
}
