<?php

namespace Goksagun\FrameworkExtraBundle\Routing\Annotation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[\Attribute]
class Post extends Route
{
    public function getMethods(): array
    {
        return [
            Request::METHOD_POST,
        ];
    }
}