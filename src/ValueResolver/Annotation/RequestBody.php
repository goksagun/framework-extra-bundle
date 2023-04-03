<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Annotation;

use Goksagun\FrameworkExtraBundle\Config\Scope;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class RequestBody
{
    private ?Scope $scope;

    public function __construct(Scope|array|null $scope = null)
    {
        if (is_array($scope)) {
            $this->scope = reset($scope);
        } else {
            $this->scope = $scope;
        }
    }

    public function getScope(): ?Scope
    {
        return $this->scope;
    }
}