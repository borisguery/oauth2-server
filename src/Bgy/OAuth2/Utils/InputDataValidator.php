<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\Utils;

use Bgy\OAuth2\GrantType\MissingOrInvalidInputData;

class InputDataValidator
{
    public static function ensureInputDataAreValid($grantTypeIdentifier, array $inputData, array $requiredDataKeys)
    {
        // check if we got the actual input data or just its keys

        $inputDataKeys = $inputData;

        if (array_keys($inputData) !== range(0, count($inputData) - 1)) {
            $inputDataKeys = array_keys($inputData);
        }

        // using == instead of === does not check the order of the properties
        if ($inputDataKeys == $requiredDataKeys) {

            throw new MissingOrInvalidInputData($grantTypeIdentifier, $inputDataKeys, $requiredDataKeys);
        }
    }
}
