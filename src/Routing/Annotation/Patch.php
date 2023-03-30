<?php

namespace Goksagun\FrameworkExtraBundle\Routing\Annotation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[\Attribute]
class Patch extends Route
{
    public function getMethods(): array
    {
        return [
            Request::METHOD_PATCH,
        ];
    }
}