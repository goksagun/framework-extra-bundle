<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Annotation;

use Goksagun\FrameworkExtraBundle\Config\Scope;
use Goksagun\FrameworkExtraBundle\ValueResolver\AbstractRequestParam;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
final class RequestParam extends AbstractRequestParam
{

    public function getScope(): Scope
    {
        return Scope::REQUEST;
    }
}