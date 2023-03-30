<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Fetcher;

use Goksagun\FrameworkExtraBundle\Config\Scope;
use Symfony\Component\HttpFoundation\Request;

class ArgumentFetcherFactory
{
    public static function create(Request $request, ?Scope $scope = null): ArgumentFetcherInterface
    {
        return match ($scope) {
            Scope::HEADERS => new HeadersArgumentFetcher($request, $scope),
            default => new DefaultArgumentFetcher($request, $scope)
        };
    }
}