# oauth2-server

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

``` bash
$ composer require borisguery/oauth2-server
```

## Usage

``` php
class OAuht2Controller {

    public function tokenAction(Request $request)
    {
        $sfPasswordGrantType = new SymfonySecurityPasswordGrantType(
            $this->container->get('security.user_provider'),
            $this->container->get('security.encoder_factory')->getEncoder(UserAccount::class)
        );

        $clientStorage = new InMemoryClientStorage();
        $defaultClient = new Client(
            'test',
            null,
            [],
            ['password']
        );

        $clientStorage->save($defaultClient);

        $configuration = (new ResourceServerConfigurationBuilder())
            ->setAccessTokenStorage(new InMemoryAccessTokenStorage())
            ->setClientStorage($clientStorage)
            ->setRefreshStorage(new InMemoryRefreshTokenStorage())
            ->setAccessTokenGenerator(new Php7CSPRNGStringGenerator())
            ->addGrantType($sfPasswordGrantType)
            ->alwaysRequireAClient(true)
            ->alwaysGenerateARefreshToken(true)
            ->build()
            ->getResourceConfiguration()
        ;

        $resourceServer = new ResourceServer($configuration);

        $inputDataBag = SymfonyHttpFoundationRequestInputDataBagFactory::fromRequest($request);

        $attemptResult = $resourceServer->requestAccessToken(
            new TokenRequestAttempt($inputDataBag->getGrantType(), $inputDataBag)
        );

        if ($attemptResult instanceof SuccessfulTokenRequestAttemptResult) {
            $statusCode = 200;
            $response = [
                'access_token' => $attemptResult->getAccessToken()->getToken(),
                'expires_in'   => $attemptResult->getAccessToken()->getExpiresIn(),
                'token_type'   => $attemptResult->getAccessToken()->getTokenType(),
                'refresh_token' => $attemptResult->getRefreshToken()
                    ? $attemptResult->getRefreshToken()->getToken()
                    : null,
            ];
        } elseif ($attemptResult instanceof FailedTokenRequestAttemptResult) {
            $statusCode = 400;
            $response = [
                'error' => (string) $attemptResult->getGrantDecision()->getError(),
                'error_description' => $attemptResult->getGrantDecision()->getError()->getErrorDescription(),
                'error_uri' => $attemptResult->getGrantDecision()->getError()->getErrorUri(),
            ];
        }

        return new Response(json_encode($response), $statusCode, ['Content-Type' => 'application/json']);
    }
}
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email guery.b@gmail.com instead of using the issue tracker.

## Credits

- [Boris Guéry][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/borisguery/oauth2-server.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/borisguery/oauth2-server/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/borisguery/oauth2-server.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/borisguery/oauth2-server.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/borisguery/oauth2-server.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/borisguery/oauth2-server
[link-travis]: https://travis-ci.org/borisguery/oauth2-server
[link-scrutinizer]: https://scrutinizer-ci.com/g/borisguery/oauth2-server/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/borisguery/oauth2-server
[link-downloads]: https://packagist.org/packages/borisguery/oauth2-server
[link-author]: https://github.com/borisguery
[link-contributors]: ../../contributors
