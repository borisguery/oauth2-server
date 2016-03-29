<?php

namespace Bgy\OAuth2\Storage\InMemory;

use Bgy\OAuth2\Storage\ClientNotFound;
use Bgy\OAuth2\Storage\ClientStorage;
use Bgy\OAuth2\Client as ClientModel;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class InMemoryClientStorage implements ClientStorage
{
    private $clients = [];

    public function save(ClientModel $client)
    {
        $this->clients[$client->getId()] = $client;
    }

    public function delete(ClientModel $client)
    {
        if (!isset($this->clients[$client->getId()])) {

            throw new ClientNotFound($client->getId());
        }

        unset($this->clients[$client->getId()]);
    }

    public function findById($clientId)
    {
        if (!isset($this->clients[$clientId])) {

            throw new ClientNotFound($clientId);
        }

        return $this->clients[$clientId];
    }
}
