<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;

use Bgy\OAuth2\ResourceOwner;
use Bgy\OAuth2\Utils\Ensure;

final class GrantDecision
{
    const ALLOWED = 'allowed';
    const DENIED  = 'denied';

    private $decision;

    /**
     * @var ResourceOwner
     */
    private $resourceOwnerId;

    /**
     * @var GrantError
     */
    private $error;

    private function __construct() {}

    public static function denied(GrantError $error)
    {
        $d = new self();
        $d->decision = self::DENIED;
        $d->error    = $error;

        return $d;
    }

    public static function allowed(ResourceOwner $resourceOwnerId = null)
    {
        $d = new self();
        $d->decision = self::ALLOWED;
        $d->resourceOwnerId = $resourceOwnerId;
        $d->error    = GrantError::none();

        return $d;
    }

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
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
