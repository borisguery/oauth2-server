<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace Bgy\OAuth2;

use Symfony\Component\HttpFoundation\Request;

class SymfonyHttpFoundationRequestInputDataBagFactory
{
    static public function fromRequest(Request $request)
    {
        return new InputDataBag(
            array_merge_recursive(
                $request->query->all(),
                $request->request->all()
            )
        );
    }
}
