<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Annotation;

use Goksagun\FrameworkExtraBundle\Config\Scope;
use Goksagun\FrameworkExtraBundle\ValueResolver\AbstractRequestParam;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class HeadersParam extends AbstractRequestParam
{

    public function getScope(): ?Scope
    {
        return Scope::HEADERS;
    }
}