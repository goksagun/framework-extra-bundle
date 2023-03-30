<?php

declare(strict_types=1);

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Resolver;

use Goksagun\FrameworkExtraBundle\ValueResolver\Annotation\QueryParam;

class QueryParamValueResolver extends AbstractParamResolver
{
    public function getAttributeName(): string
    {
        return QueryParam::class;
    }
}