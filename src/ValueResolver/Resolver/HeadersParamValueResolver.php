<?php

declare(strict_types=1);

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Resolver;

use Goksagun\FrameworkExtraBundle\ValueResolver\Annotation\HeadersParam;

class HeadersParamValueResolver extends AbstractParamResolver
{

    public function getAttributeName(): string
    {
        return HeadersParam::class;
    }
}