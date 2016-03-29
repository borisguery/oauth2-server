<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

class TokenRequestAttempt
{
    private $grantType;
    private $inputData;

    public function __construct($grantType, InputDataBag $inputData)
    {
        $this->grantType = $grantType;
        $this->inputData = $inputData;
    }

    public function getGrantType()
    {
        return $this->grantType;
    }

    public function getInputData()
    {
        return $this->inputData;
    }
}
