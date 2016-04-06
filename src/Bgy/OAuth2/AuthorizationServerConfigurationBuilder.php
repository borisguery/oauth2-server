<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

class AuthorizationServerConfigurationBuilder
{
    private $defaultOptions = [
        'access_token_generator'          => null,
        'always_require_a_client'         => false,
        'access_token_length'             => 32,
        'access_token_ttl'                => 3600,
        'always_generate_a_refresh_token' => false,
        'revoke_refresh_token_when_used'  => true,
    ];

    private $options = [
        'access_token_generator'          => null,
        'always_require_a_client'         => false,
        'access_token_length'             => 32,
        'access_token_ttl'                => 3600,
        'always_generate_a_refresh_token' => false,
        'revoke_refresh_token_when_used'  => true,
    ];

    private $built = false;

    private $configuration;

    public function __construct()
    {
    }

    public function alwaysRequireAClient($flag)
    {
        $this->options['always_require_a_client'] = (bool) $flag;

        return $this;
    }

    public function shouldRevokeRefreshTokenWhenUsed($flag)
    {
        $this->options['revoke_refresh_token_when_used'] = (bool) $flag;

        return $this;
    }

    public function alwaysGenerateARefreshToken($flag)
    {
        $this->options['always_generate_a_refresh_token'] = (bool) $flag;

        return $this;
    }

    public function setAccessTokenTTL($ttlInSeconds)
    {
        $this->options['access_token_ttl'] = (int) $ttlInSeconds;

        return $this;

    }

    public function setAccessTokenGenerator($accessTokenGenerator)
    {
        $this->options['access_token_generator'] = $accessTokenGenerator;

        return $this;
    }

    public function build()
    {
        // all options without a default value (not null) are required
        $missingOptions  = array_filter($this->options, function ($value, $key) {
            return (null === $value);
        }, ARRAY_FILTER_USE_BOTH);

        if (count($missingOptions) > 0) {

            throw new \RuntimeException(sprintf(
                'You must configure the following options: %s',
                rtrim(implode(", ", array_keys($missingOptions)), ", ")
            ));
        }

        $this->built = true;

        $this->configuration = new AuthorizationServerConfiguration(
            $this->options['access_token_generator'],
            [
                'always_require_a_client'         => $this->options['always_require_a_client'],
                'access_token_ttl'                => $this->options['access_token_ttl'],
                'access_token_length'             => $this->options['access_token_length'],
                'always_generate_a_refresh_token' => $this->options['always_generate_a_refresh_token'],
            ]
        );

        return $this;
    }

    public function reset()
    {
        $this->options = $this->defaultOptions;

        $this->built = false;
    }

    public function getAuthorizationServerConfiguration()
    {
        if (!$this->built) {

            throw new \LogicException('You must build() the configuration before to get it.');
        }

        return $this->configuration;
    }
}
