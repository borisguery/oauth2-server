<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

class TokenRequestAttempt
{
    private $inputData;

    public function __construct(InputDataBag $inputData)
    {
        $this->inputData = $inputData;
    }

    public function getGrantType()
    {
        return $this->inputData->getGrantType();
    }

    public function getInputData()
    {
        return $this->inputData;
    }
}
