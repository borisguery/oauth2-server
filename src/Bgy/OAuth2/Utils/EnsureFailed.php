<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\Utils;

use Assert\InvalidArgumentException;
use Bgy\OAuth2\Exception;

class EnsureFailed extends InvalidArgumentException implements Exception {}
