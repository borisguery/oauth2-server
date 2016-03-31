<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;

use Bgy\OAuth2\ClientAuthenticator;
use Bgy\OAuth2\Storage\ClientStorage;
use Bgy\OAuth2\TokenRequestAttempt;
use Bgy\OAuth2\Utils\GrantTypeUtils;

class ClientCredentialsGrantType implements GrantType
{
    private $clientAuthenticator;

    public function __construct(ClientAuthenticator $clientAuthenticator)
    {
        $this->clientAuthenticator = $clientAuthenticator;
    }

    public function grant(TokenRequestAttempt $tokenRequestAttempt)
    {
        GrantTypeUtils::ensureRequestedGrantTypeIsSupported($this, $tokenRequestAttempt);

        try {
            GrantTypeUtils::ensureInputDataAreValid($this, $tokenRequestAttempt);

        } catch (MissingOrInvalidInputData $e) {

            return GrantDecision::denied(GrantError::invalidRequest($e->getMessage()));
        }

        if (true === $this->clientAuthenticator->isClientValid(
                $tokenRequestAttempt->getInputData()->getClientId(),
                $tokenRequestAttempt->getInputData()->getClientSecret()
            )
        ) {

            return GrantDecision::allowed();
        }

        return GrantDecision::denied(GrantError::accessDenied());
    }

    public function getRequiredInputData()
    {
        return [
            'client_id',
            'client_secret',
        ];
    }

    public function getIdentifier()
    {
        return 'client_credentials';
    }
}
