<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\Storage;

use Bgy\OAuth2\Exception;

class AccessTokenNotFound extends \DomainException implements Exception
{
    public function __construct($accessToken)
    {
        parent::__construct(sprintf(
            'Bgy\OAuth2 Access Token "%s" not found',
            $accessToken
        ));
    }
}
