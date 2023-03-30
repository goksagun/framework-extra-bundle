<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver;

use Goksagun\FrameworkExtraBundle\Config\Scope;

interface RequestParamInterface
{
    public function getName(): ?string;

    public function getScope(): ?Scope;

    public function isRequired(): bool;
}