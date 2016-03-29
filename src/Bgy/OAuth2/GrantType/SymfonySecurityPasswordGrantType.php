<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;

use Bgy\OAuth2\TokenRequestAttempt;
use Bgy\OAuth2\Utils\GrantTypeUtils;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SymfonySecurityPasswordGrantType implements GrantType
{
    private $userProvider;
    private $passwordEncoder;

    public function __construct(UserProviderInterface $userProvider, PasswordEncoderInterface $passwordEncoder)
    {
        $this->userProvider    = $userProvider;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function grant(TokenRequestAttempt $tokenRequestAttempt)
    {
        GrantTypeUtils::ensureRequestedGrantTypeIsSupported($this, $tokenRequestAttempt);
        try {
            GrantTypeUtils::ensureInputDataAreValid($this, $tokenRequestAttempt);
        } catch (MissingOrInvalidInputData $e) {

            return GrantDecision::denied(GrantError::invalidRequest($e->getMessage()));
        }

        $inputData = $tokenRequestAttempt->getInputData();
        $username          = $inputData['username'];
        $plainTextPassword = $inputData['password'];

        try {
            $userAccount = $this->userProvider->loadUserByUsername($username);

            $isPasswordValid = $this->passwordEncoder->isPasswordValid(
                $userAccount->getPassword(),
                $plainTextPassword,
                $userAccount->getSalt()
            );

            if ($isPasswordValid) {
                $decision = GrantDecision::allowed();
            } else {
                $decision = GrantDecision::denied(GrantError::accessDenied('Invalid credentials'));
            }

        } catch (UsernameNotFoundException $e) {
            $decision = GrantDecision::denied(GrantError::accessDenied('Invalid credentials'));
        } catch (\Exception $e) {
            $decision = GrantDecision::denied(GrantError::serverError('Unknown error'));
        }

        return $decision;
    }

    public function getRequiredInputData()
    {
        return [
            'username',
            'password',
        ];
    }

    public function getIdentifier()
    {
        return 'password';
    }
}
