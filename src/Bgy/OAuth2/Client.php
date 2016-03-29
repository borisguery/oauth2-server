<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

class Client
{
    private $id;
    private $secret;
    private $redirectUris = [];
    private $allowedGrantTypes = [];

    public function __construct($id, $secret, array $redirectUris = [], array $allowedGrantTypes = [])
    {
        $this->id                = $id;
        $this->secret            = $secret;
        $this->redirectUris      = $redirectUris;
        $this->allowedGrantTypes = $allowedGrantTypes;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getRedirectUris()
    {
        return $this->redirectUris;
    }

    public function getAllowedGrantTypes()
    {
        return $this->allowedGrantTypes;
    }
}
