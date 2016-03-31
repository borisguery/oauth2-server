<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\Utils;

use Assert\Assertion as AssertBase;

class Assertion extends AssertBase
{
    protected static $exceptionClass = 'Bgy\OAuth2\Utils\EnsureFailed';
}
