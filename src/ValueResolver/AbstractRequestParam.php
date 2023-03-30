<?php

declare(strict_types=1);

namespace Goksagun\FrameworkExtraBundle\ValueResolver;

abstract class AbstractRequestParam implements RequestParamInterface
{
    public function __construct(private ?string $name = null, private bool $required = false)
    {
    }

    public function __toString(): string
    {
        return "Values name:'" . $this->name . "', required:'" . $this->required . "'";
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }
}