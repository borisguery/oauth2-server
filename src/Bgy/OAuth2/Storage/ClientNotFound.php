<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\Storage;

use Bgy\OAuth2\Exception;

class ClientNotFound extends \DomainException implements Exception
{
    public function __construct($clientId)
    {
        parent::__construct(sprintf(
            'Bgy\OAuth2 Client "%s" not found',
            $clientId
        ));
    }
}
