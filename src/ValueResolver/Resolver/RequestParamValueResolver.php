<?php

declare(strict_types=1);

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Resolver;

use Goksagun\FrameworkExtraBundle\ValueResolver\Annotation\RequestParam;

class RequestParamValueResolver extends AbstractParamResolver
{
    public function getAttributeName(): string
    {
        return RequestParam::class;
    }
}