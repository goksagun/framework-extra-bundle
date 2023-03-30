<?php

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Fetcher;

class HeadersArgumentFetcher extends AbstractFetcher
{

    public function fetch(?string $name = null): mixed
    {
        $name = $this->toTitleKebabCase($name);

        return $this->request->{$this->scope->value}->get($name);
    }

    private function toTitleKebabCase(string $input): string
    {
        // convert to camelCase if input is snake_case
        $input = str_replace(' ', '', ucwords(str_replace('_', ' ', $input)));

        // convert camelCase to Title-Kebab-Case
        return ucwords(preg_replace('/(?<=\\w)(?=[A-Z])/', '-', $input));
    }
}