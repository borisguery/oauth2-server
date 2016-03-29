<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

interface TokenGenerator
{
    /**
     * @param array $options Any forms of data which may be required by the generator
     * @return string
     */
    public function generate(array $options = []);
}
