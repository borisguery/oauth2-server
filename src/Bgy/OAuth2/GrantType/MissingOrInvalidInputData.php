<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2\GrantType;

class MissingOrInvalidInputData extends \InvalidArgumentException
{
    private $inputDataKeys    = [];
    private $requiredDataKeys = [];

    public function __construct($grantTypeIdentifier, array $inputDataKeys, array $requiredDataKeys)
    {
        $this->inputDataKeys    = $inputDataKeys;
        $this->requiredDataKeys = $requiredDataKeys;

        parent::__construct(sprintf(
                                'The grant_type "%s" requires the following data : "%s" but got "%s"',
                                $grantTypeIdentifier,
                                rtrim(implode(', ', $requiredDataKeys), ", "),
                                rtrim(implode(', ', $inputDataKeys), ", ")
                            ));
    }

    public function getRequiredDataKeys()
    {
        return $this->requiredDataKeys;
    }

    public function getInputDataKeys()
    {
        return $this->inputDataKeys;
    }
}
