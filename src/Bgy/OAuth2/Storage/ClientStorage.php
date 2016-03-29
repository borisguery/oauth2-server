<?php

namespace Bgy\OAuth2\Storage;

use Bgy\OAuth2\Client;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

interface ClientStorage
{
    public function save(Client $client);

    /**
     * @param Client $client
     * @return void
     * @throws ClientNotFound
     */
    public function delete(Client $client);

    /**
     * @param $clientId
     * @return Client
     * @throws ClientNotFound
     */
    public function findById($clientId);
}
