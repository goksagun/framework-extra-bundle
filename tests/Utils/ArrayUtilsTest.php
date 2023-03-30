<?php

namespace Goksagun\FrameworkExtraBundle\Tests\Utils;

use Goksagun\FrameworkExtraBundle\Utils\ArrayUtils;
use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{

    public function testOnly()
    {
        $this->assertEquals(['foo' => 'Foo'], ArrayUtils::only(['foo' => 'Foo', 'bar' => 'Bar'], 'foo'));
    }
}
