<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\GrantType\GrantDecision;
use Bgy\OAuth2\GrantType\GrantError;
use Bgy\OAuth2\GrantType\GrantType;

class AuthorizationServer
{
    private $configuration;
    private $clientAuthenticator;

    public function __construct(AuthorizationServerConfiguration $configuration)
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
        if (!$this->checkGrantType($tokenRequestAttempt)) {

            return new FailedTokenRequestAttemptResult(GrantDecision::denied(GrantError::invalidGrant('Unknown grant type')));
        }

        if ($this->checkIfAClientIsAlwaysRequired()) {

            if (!$this->checkIfAClientIsProvided($tokenRequestAttempt)) {

                return new FailedTokenRequestAttemptResult(GrantDecision::denied(GrantError::invalidGrant('Missing client_id')));
            }

            if (!$this->checkIfTheProvidedClientIsValid($tokenRequestAttempt)) {

                return new FailedTokenRequestAttemptResult(GrantDecision::denied(GrantError::accessDenied('Invalid client credentials')));
            }

            if (!$this->checkIfClientSupportsRequestedGrantType($tokenRequestAttempt)) {

                return new FailedTokenRequestAttemptResult(
                    GrantDecision::denied(
                        GrantError::invalidGrant(
                            sprintf(
                                'This client doesn\'t support the following grant type: "%s"',
                                $tokenRequestAttempt->getGrantType()
                            )
                        )
                    )
                );
            }
        }

        $grantDecision = $this->getGrantTypeByIdentifier($tokenRequestAttempt->getGrantType())
            ->grant($tokenRequestAttempt)
        ;

        if ($grantDecision->equals(GrantDecision::allowed())) {

            $accessToken = $this->buildAccessToken($tokenRequestAttempt, $grantDecision);
            $refreshToken = $this->buildRefreshToken($accessToken);

            return new SuccessfulTokenRequestAttemptResult($grantDecision, $accessToken, $refreshToken);
        }

        return new FailedTokenRequestAttemptResult($grantDecision);
    }

    private function checkGrantType(TokenRequestAttempt $tokenRequestAttempt)
    {
        return (null !== $this->getGrantTypeByIdentifier($tokenRequestAttempt->getGrantType()));
    }

    private function checkIfAClientIsAlwaysRequired()
    {

        return $this->configuration->alwaysRequireAClient();
    }

    private function checkIfAClientIsProvided(TokenRequestAttempt $tokenRequestAttempt)
    {
        return (false === $tokenRequestAttempt->getInputData()->getClientId());
    }

    private function checkIfTheProvidedClientIsValid(TokenRequestAttempt $tokenRequestAttempt)
    {
        return $this->clientAuthenticator->isClientValid(
            $tokenRequestAttempt->getInputData()->getClientId(),
            $tokenRequestAttempt->getInputData()->getClientSecret()
        );
    }

    private function checkIfClientSupportsRequestedGrantType(TokenRequestAttempt $tokenRequestAttempt)
    {
        $client = $this->configuration->getClientStorage()
            ->findById($tokenRequestAttempt->getInputData()->getClientId())
        ;

        return in_array($tokenRequestAttempt->getGrantType(), $client->getAllowedGrantTypes());
    }

    private function buildAccessToken(TokenRequestAttempt $tokenRequestAttempt, GrantDecision $grantDecision)
    {
        if ($grantDecision->isDenied()) {

            throw new \LogicException('Unable to build an access token with a denied decision');
        }

        $token = $this->configuration->getTokenGenerator()->generate(
            ['length' => $this->configuration->getAccessTokenLength()]
        )
        ;

        $accessToken = new AccessToken(
            $token,
            \DateTimeImmutable::createFromFormat(
                'U',
                date('U') + $this->configuration->getAccessTokenTTL(),
                new \DateTimeZone('UTC')
            ),
            $tokenRequestAttempt->getInputData()->getClientId(),
            $grantDecision->getResourceOwnerId(),
            []
        );

        $this->configuration->getAccessTokenStorage()->save($accessToken);

        return $accessToken;
    }

    private function buildRefreshToken(AccessToken $accessToken)
    {
        $refreshToken = null;
        if ($this->configuration->alwaysGenerateARefreshToken()) {
            $token = $this->configuration->getTokenGenerator()->generate(
                ['length' => $this->configuration->getAccessTokenLength()]
            )
            ;
            $refreshToken = new RefreshToken($token);

            $this->configuration->getRefreshTokenStorage()->save($refreshToken);
        }

        return $refreshToken;
    }

    /**
     * @param $identifier
     * @return GrantType
     */
    private function getGrantTypeByIdentifier($identifier)
    {
        foreach ($this->configuration->getGrantTypeExtensions() as $grantTypeExtension) {
            if (strtolower($identifier) === strtolower($grantTypeExtension->getIdentifier())) {

                return $grantTypeExtension;
            }
        }

        return null;
    }
}
