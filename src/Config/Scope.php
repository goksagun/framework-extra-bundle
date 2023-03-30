<?php

namespace Goksagun\FrameworkExtraBundle\Config;

enum Scope: string
{
    case QUERY = 'query';
    case REQUEST = 'request';
    case HEADERS = 'headers';
    case ATTRIBUTES = 'attributes';
}
