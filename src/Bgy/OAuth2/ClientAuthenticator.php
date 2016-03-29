<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\Storage\ClientNotFound;
use Bgy\OAuth2\Storage\ClientStorage;

class ClientAuthenticator
{
    private $clientStorage;

    public function __construct(ClientStorage $storage)
    {
        $this->clientStorage = $storage;
    }

    public function isClientValid($clientId, $clientSecret)
    {
        try {
            $client = $this->clientStorage->findById($clientId);
        } catch (ClientNotFound $e) {

            return false;
        }

        return ((string) $client->getSecret() === (string) $clientSecret);
    }
}
