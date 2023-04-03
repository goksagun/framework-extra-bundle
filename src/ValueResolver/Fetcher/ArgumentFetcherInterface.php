<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Fetcher;

interface ArgumentFetcherInterface
{
    public function fetch(?string $name = null): mixed;

    public function fetchAll(): mixed;
}