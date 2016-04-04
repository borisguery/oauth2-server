<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;

use Bgy\OAuth2\ResourceOwner;
use Bgy\OAuth2\Storage\RefreshTokenNotFound;
use Bgy\OAuth2\Storage\RefreshTokenStorage;
use Bgy\OAuth2\TokenRequestAttempt;
use Bgy\OAuth2\Utils\GrantTypeUtils;

class RefreshTokenGrantType implements GrantType
{
    private $refreshTokenStorage;

    public function __construct(RefreshTokenStorage $refreshTokenStorage = null)
    {
        $this->refreshTokenStorage = $refreshTokenStorage;
    }

    public function setRefreshTokenStorage(RefreshTokenStorage $refreshTokenStorage)
    {
        $this->refreshTokenStorage = $refreshTokenStorage;
    }

    public function grant(TokenRequestAttempt $tokenRequestAttempt)
    {
        GrantTypeUtils::ensureRequestedGrantTypeIsSupported($this, $tokenRequestAttempt);

        try {
            GrantTypeUtils::ensureInputDataAreValid($this, $tokenRequestAttempt);

        } catch (MissingOrInvalidInputData $e) {

            return GrantDecision::denied(GrantError::invalidRequest($e->getMessage()));
        }

        try {

            $refreshToken = $this->refreshTokenStorage->findByToken($tokenRequestAttempt->getInputData()->getRefreshToken());

            return GrantDecision::allowed(
                new ResourceOwner(
                    $refreshToken->getAssociatedAccessToken()->getResourceOwner()->getResourceOwnerId(),
                    $refreshToken->getAssociatedAccessToken()->getResourceOwner()->getResourceOwnerType()
                )
            );

        } catch (RefreshTokenNotFound $e) {

            return GrantDecision::denied(GrantError::accessDenied());
        }

        return GrantDecision::denied(GrantError::accessDenied());
    }

    public function getRequiredInputData()
    {
        return [
            'refresh_token',
        ];
    }

    public function getIdentifier()
    {
        return 'refresh_token';
    }
}
