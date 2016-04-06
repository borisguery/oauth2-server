<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\Utils\Ensure;

class ResourceOwner
{
    private $resourceOwnerId;
    private $resourceOwnerType;

    public function __construct($resourceOwnerId, $resourceOwnerType)
    {
        Ensure::string($resourceOwnerId, $resourceOwnerType);
        $this->resourceOwnerId   = $resourceOwnerId;
        $this->resourceOwnerType = $resourceOwnerType;
    }

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    public function getResourceOwnerType()
    {
        return $this->resourceOwnerType;
    }
}
