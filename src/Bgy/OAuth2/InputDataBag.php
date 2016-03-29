<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

class InputDataBag implements \ArrayAccess
{
    // known properties, sensible defaults
    const CLIENT_ID     = 'client_id';
    const CLIENT_SECRET = 'client_secret';
    const GRANT_TYPE    = 'grant_type';
    const USERNAME      = 'username';
    const PASSWORD      = 'password';
    const REFRESH_TOKEN = 'refresh_token';
    const RESPONSE_TYPE = 'response_type';
    const CODE          = 'code';
    const REDIRECT_URI  = 'redirect_uri';

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get($property, $default = null)
    {
        return isset($this->data[$property]) ? $this->data[$property] : $default;
    }

    public function all()
    {
        return $this->data;
    }

    public function getClientId()
    {
        return $this->get(self::CLIENT_ID);
    }

    public function getClientSecret()
    {
        return $this->get(self::CLIENT_SECRET);
    }

    public function getGrantType()
    {
        return $this->get(self::GRANT_TYPE);
    }

    public function getUsername()
    {
        return $this->get(self::USERNAME);
    }

    public function getPassword()
    {
        return $this->get(self::PASSWORD);
    }

    public function getResponseType()
    {
        return $this->get(self::RESPONSE_TYPE);
    }

    public function getCode()
    {
        return $this->get(self::CODE);
    }

    public function getRefreshToken()
    {
        return $this->get(self::REFRESH_TOKEN);
    }

    public function getRedirectUri()
    {
        return $this->get(self::REDIRECT_URI);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new \LogicException(sprintf('Cannot set "%s", InputDataBag is immutable.', $offset));
    }

    public function offsetUnset($offset)
    {
        throw new \LogicException(sprintf('Cannot unset "%s", InputDataBag is immutable.', $offset));
    }
}
