<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;

final class GrantError
{
    const INVALID_REQUEST           = 'invalid_request';
    const UNAUTHORIZED_CLIENT       = 'unauthorized_client';
    const ACCESS_DENIED             = 'access_denied';
    const UNSUPPORTED_RESPONSE_TYPE = 'unsupported_response_type';
    const INVALID_SCOPE             = 'invalid_scope';
    const INVALID_GRANT             = 'invalid_grant';
    const SERVER_ERROR              = 'server_error';
    const TEMPORARILY_UNAVAILABLE   = 'temporarily_unavailable';
    const NONE                      = 'none';

    private $error;
    private $errorDescription;
    private $errorUri;

    private function __construct() {}

    public static function invalidRequest($errorDescription = null, $errorUri = null)
    {
        $e = new self();
        $e->error            = self::INVALID_REQUEST;
        $e->errorDescription = $errorDescription;
        $e->errorUri         = $errorUri;

        return $e;
    }

    public static function unauthorizedClient($errorDescription = null, $errorUri = null)
    {
        $e = new self();
        $e->error            = self::UNAUTHORIZED_CLIENT;
        $e->errorDescription = $errorDescription;
        $e->errorUri         = $errorUri;

        return $e;
    }

    public static function accessDenied($errorDescription = null, $errorUri = null)
    {
        $e = new self();
        $e->error            = self::ACCESS_DENIED;
        $e->errorDescription = $errorDescription;
        $e->errorUri         = $errorUri;

        return $e;
    }

    public static function unsupportedResponseType($errorDescription = null, $errorUri = null)
    {
        $e = new self();
        $e->error            = self::UNSUPPORTED_RESPONSE_TYPE;
        $e->errorDescription = $errorDescription;
        $e->errorUri         = $errorUri;

        return $e;
    }


    public static function invalidGrant($errorDescription = null, $errorUri = null)
    {
        $e = new self();
        $e->error            = self::INVALID_GRANT;
        $e->errorDescription = $errorDescription;
        $e->errorUri         = $errorUri;

        return $e;
    }

    public static function invalidScope($errorDescription = null, $errorUri = null)
    {
        $e = new self();
        $e->error            = self::INVALID_SCOPE;
        $e->errorDescription = $errorDescription;
        $e->errorUri         = $errorUri;

        return $e;
    }

    public static function temporarilyUnavailable($errorDescription = null, $errorUri = null)
    {
        $e = new self();
        $e->error            = self::TEMPORARILY_UNAVAILABLE;
        $e->errorDescription = $errorDescription;
        $e->errorUri         = $errorUri;

        return $e;
    }

    public static function serverError($errorDescription = null, $errorUri = null)
    {
        $e = new self();
        $e->error            = self::SERVER_ERROR;
        $e->errorDescription = $errorDescription;
        $e->errorUri         = $errorUri;

        return $e;
    }

    public static function none()
    {
        $e = new self();
        $e->error = self::NONE;

        return $e;
    }

    public function getError()
    {
        return $this->error;
    }

    public function __toString()
    {
        return $this->error;
    }

    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    public function getErrorUri()
    {
        return $this->errorUri;
    }
}
