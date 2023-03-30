<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Fetcher;

use Goksagun\FrameworkExtraBundle\Config\Scope;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractFetcher implements ArgumentFetcherInterface
{
    public function __construct(protected Request $request, protected ?Scope $scope = null)
    {
    }
}