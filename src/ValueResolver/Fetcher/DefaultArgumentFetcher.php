<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Fetcher;

class DefaultArgumentFetcher extends AbstractFetcher
{

    public function fetch(?string $name = null): mixed
    {
        return $this->request->{$this->scope->value}->get($name);
    }
}