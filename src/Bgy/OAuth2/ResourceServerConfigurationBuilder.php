<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Bgy\OAuth2\GrantType\GrantType;
use Bgy\OAuth2\Storage\AccessTokenStorage;
use Bgy\OAuth2\Storage\ClientStorage;
use Bgy\OAuth2\Storage\RefreshTokenStorage;

class ResourceServerConfigurationBuilder
{
    private $defaultOptions = [
        'client_storage'                  => null,
        'access_token_storage'            => null,
        'refresh_token_storage'           => null,
        'access_token_generator'          => null,
        'always_require_a_client'         => false,
        'access_token_length'             => 32,
        'access_token_ttl'                => 3600,
        'always_generate_a_refresh_token' => false,
        'grant_types'                     => []
    ];

    private $options = [
        'client_storage'                  => null,
        'access_token_storage'            => null,
        'refresh_token_storage'           => null,
        'access_token_generator'          => null,
        'always_require_a_client'         => false,
        'access_token_length'             => 32,
        'access_token_ttl'                => 3600,
        'always_generate_a_refresh_token' => false,
        'grant_types'                     => []
    ];

    private $built = false;

    private $configuration;

    public function __construct()
    {
    }

    public function setClientStorage(ClientStorage $clientStorage)
    {
        $this->options['client_storage'] = $clientStorage;

        return $this;
    }

    public function setAccessTokenStorage(AccessTokenStorage $clientStorage)
    {
        $this->options['access_token_storage'] = $clientStorage;

        return $this;
    }

    public function setRefreshStorage(RefreshTokenStorage $clientStorage)
    {
        $this->options['refresh_token_storage'] = $clientStorage;

        return $this;
    }

    public function alwaysRequireAClient($flag)
    {
        $this->options['always_require_a_client'] = (bool) $flag;

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

    public function addGrantType(GrantType $grantType, $overrideExisting = false)
    {
        if (isset($this->options['grant_types'][$grantType->getIdentifier()]) && !$overrideExisting) {

            throw UnableToAddGrantType::aGrantTypeExtensionIsAlreadyRegisteredForThisIdentifier(
                $grantType->getIdentifier(),
                get_class($this->options['grant_types'][$grantType->getIdentifier()])
            );
        }

        $this->options['grant_types'][$grantType->getIdentifier()] = $grantType;

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

        $this->configuration = new ResourceServerConfiguration(
            $this->options['client_storage'],
            $this->options['access_token_storage'],
            $this->options['refresh_token_storage'],
            $this->options['grant_types'],
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

    public function getResourceConfiguration()
    {
        if (!$this->built) {

            throw new \LogicException('You must build() the configuration before to get it.');
        }

        return $this->configuration;
    }
}
