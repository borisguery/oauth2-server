<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\GrantType\GrantDecision;
use Bgy\OAuth2\GrantType\GrantError;
use Bgy\OAuth2\GrantType\GrantType;

class ResourceServer
{
    private $configuration;
    private $clientAuthenticator;

    public function __construct(ResourceServerConfiguration $configuration)
    {
        $this->configuration       = $configuration;
        $this->clientAuthenticator = new ClientAuthenticator(
            $this->configuration->getClientStorage()
        );
    }

    /**
     * @param TokenRequestAttempt $tokenRequestAttempt
     * @return FailedTokenRequestAttemptResult|SuccessfulTokenRequestAttemptResult
     */
    public function requestAccessToken(TokenRequestAttempt $tokenRequestAttempt)
    {
        if (null === $this->getGrantTypeByIdentifier($tokenRequestAttempt->getGrantType())) {

            return $this->buildTokenAttemptResult($tokenRequestAttempt, GrantDecision::denied(GrantError::invalidGrant('Unknown grant type')));
        }

        if ($this->configuration->alwaysRequireAClient()) {

            if (false === $tokenRequestAttempt->getInputData()->getClientId()) {

                return $this->buildTokenAttemptResult($tokenRequestAttempt, GrantDecision::denied(GrantError::invalidRequest('missing client_id')));
            }

            if (false === $this->clientAuthenticator->isClientValid(
                $tokenRequestAttempt->getInputData()->getClientId(),
                $tokenRequestAttempt->getInputData()->getClientSecret()
            )) {

                return $this->buildTokenAttemptResult($tokenRequestAttempt, GrantDecision::denied(GrantError::accessDenied('invalid client credentials')));
            }

            $client = $this->configuration->getClientStorage()
                ->findById($tokenRequestAttempt->getInputData()->getClientId())
            ;

            if (!in_array($tokenRequestAttempt->getGrantType(), $client->getAllowedGrantTypes())) {

                return $this->buildTokenAttemptResult($tokenRequestAttempt, GrantDecision::denied(
                    GrantError::invalidGrant(
                        sprintf(
                            'This client doesn\'t support the following grant type: "%s"',
                            $tokenRequestAttempt->getGrantType()
                        )
                    )
                ));
            }

            return $this->buildTokenAttemptResult($tokenRequestAttempt, $this->getGrantTypeByIdentifier($tokenRequestAttempt->getGrantType())
                ->grant($tokenRequestAttempt)
            );
        }

        return $this->buildTokenAttemptResult($tokenRequestAttempt, GrantDecision::denied(GrantError::serverError('unknown error')));
    }

    private function buildTokenAttemptResult(TokenRequestAttempt $tokenRequestAttempt, GrantDecision $grantDecision)
    {
        if ($grantDecision->isAllowed()) {

            $token = $this->configuration->getTokenGenerator()->generate(
                ['length' => $this->configuration->getAccessTokenLength()]
            );

            $accessToken = new AccessToken(
                $token,
                $this->configuration->getAccessTokenTTL(),
                $tokenRequestAttempt->getInputData()->getClientId(),
                "",
                "bearer",
                []
            );

            $this->configuration->getAccessTokenStorage()->save($accessToken);

            $refreshToken = null;
            if ($this->configuration->alwaysGenerateARefreshToken()) {
                $token = $this->configuration->getTokenGenerator()->generate(
                    ['length' => $this->configuration->getAccessTokenLength()]
                );
                $refreshToken = new RefreshToken($token);

                $this->configuration->getRefreshTokenStorage()->save($refreshToken);
            }

            $result = new SuccessfulTokenRequestAttemptResult($grantDecision, $accessToken, $refreshToken);

        } else {
            $result = new FailedTokenRequestAttemptResult($grantDecision);
        }

        return $result;
    }

    /**
     * @param $identifier
     * @return GrantType
     */
    private function getGrantTypeByIdentifier($identifier)
    {
        if (!isset($this->configuration->getGrantTypeExtensions()[$identifier])) {

            return null;
        }

        return $this->configuration->getGrantTypeExtensions()[$identifier];
    }
}
