<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;


/**
 * The class name is voluntary redundant to make it readable : )
 */
class Php7CSPRNGStringGenerator implements TokenGenerator
{
    public function generate(array $options = [])
    {
        return str_replace(['+', '/', '='], "", base64_encode(bin2hex(random_bytes(32))));
    }
}
