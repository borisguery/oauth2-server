<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;


class GrantDecision
{
    const ALLOWED = 'allowed';
    const DENIED  = 'denied';

    private $decision;

    /**
     * @var GrantError
     */
    private $error;

    private function __construct() {}

    static public function denied(GrantError $error)
    {
        $d = new self();
        $d->decision = self::DENIED;
        $d->error    = $error;

        return $d;
    }

    static public function allowed()
    {
        $d = new self();
        $d->decision = self::ALLOWED;
        $d->error    = GrantError::none();

        return $d;
    }

    public function getError()
    {
        return $this->error;
    }

    public function isAllowed()
    {
        return $this->decision === self::ALLOWED;
    }

    public function isDenied()
    {
        return $this->decision === self::DENIED;
    }

    public function __toString()
    {
        return $this->decision;
    }

    public function equals(self $decision)
    {
        return $this->decision === $decision->decision;
    }
}
