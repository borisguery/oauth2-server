<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\Utils;

use Bgy\OAuth2\GrantType\GrantType;
use Bgy\OAuth2\GrantType\MissingOrInvalidInputData;
use Bgy\OAuth2\GrantType\UnsupportedGrantType;
use Bgy\OAuth2\TokenRequestAttempt;

class GrantTypeUtils
{
    public static function ensureRequestedGrantTypeIsSupported(GrantType $grantType, TokenRequestAttempt $tokenRequestAttempt)
    {
        if (strtolower($grantType->getIdentifier()) !== strtolower($tokenRequestAttempt->getGrantType())) {

            throw new UnsupportedGrantType(self::class, $grantType->getIdentifier(), $tokenRequestAttempt->getGrantType());
        }
    }

    public static function ensureInputDataAreValid(GrantType $grantType, TokenRequestAttempt $tokenRequestAttempt)
    {
        $inputDataKeys = $tokenRequestAttempt->getInputData()->all();

        // check if we got the actual input data or just its keys
        if (array_keys($tokenRequestAttempt->getInputData()->all()) !== range(0, count($tokenRequestAttempt->getInputData()->all()) - 1)) {

            $inputDataKeys = array_keys($tokenRequestAttempt->getInputData()->all());
        }

        // using != instead of !== does not check the order of the properties
        if ($grantType->getRequiredInputData() != array_values(array_intersect($inputDataKeys, $grantType->getRequiredInputData()))) {

            throw new MissingOrInvalidInputData($grantType->getIdentifier(), $inputDataKeys, $grantType->getRequiredInputData());
        }
    }
}
