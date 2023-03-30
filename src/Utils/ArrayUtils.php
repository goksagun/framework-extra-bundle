<?php

namespace Goksagun\FrameworkExtraBundle\Utils;

final class ArrayUtils
{
    private function __construct()
    {
    }

    public static function only(array $haystack, string|array $needles): array
    {
        $result = [];
        foreach ((array)$needles as $needle) {
            if (array_key_exists($needle, $haystack)) {
                $result[$needle] = $haystack[$needle];
            }
        }

        return $result;
    }
}