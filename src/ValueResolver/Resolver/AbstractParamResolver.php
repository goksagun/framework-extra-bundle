<?php

declare(strict_types=1);

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Resolver;

use Goksagun\FrameworkExtraBundle\Config\Scope;
use Goksagun\FrameworkExtraBundle\ValueResolver\Fetcher\ArgumentFetcherFactory;
use Goksagun\FrameworkExtraBundle\ValueResolver\RequestParamInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

abstract class AbstractParamResolver implements
    ValueResolverInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public abstract function getAttributeName(): string;

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $attrName = $this->getAttributeName(); // "Goksagun\FrameworkExtraBundle\Component\ValueResolver\<ParamInterface>"

        /** @var array<RequestParamInterface> $attrs */
        if (!$attrs = $argument->getAttributes($attrName)) {
            return [];
        }

        $resolverName = $this->getResolverShortClassName();

        $attr = $this->getAttribute($attrs);
        $attrShortName = $this->getAttributeShortClassName($attr);

        $argumentName = $argument->getName();

        $this->logger->debug(
            "Found [" . $attrShortName . "] annotation/attribute on argument '" . $argumentName . "', applying [" . $resolverName . "]"
        );

        $type = $argument->getType();
        $nullable = $argument->isNullable();

        $this->logger->debug("The method argument type: '" . $type . "' and nullable: '" . $nullable . "'");

        $name = $attr->getName() ?? $argumentName;
        $required = $attr->isRequired() ?? false;
        $scope = $attr->getScope();

        if (!in_array($scope, Scope::cases())) {
            throw new \InvalidArgumentException("Request scope '" . $scope->value . "' is not valid.");
        }

        $this->logger->debug(
            "Polished " . $attrShortName . " values name:'" . $name . "', required:'" . $required . "'"
        );

        $value = ArgumentFetcherFactory::create($request, $scope)->fetch($name);

        $this->logger->debug("The request " . $scope->value . " parameter value:'" . $value . "'");

        if (!$value && $argument->hasDefaultValue()) {
            $value = $argument->getDefaultValue();

            $this->logger->debug("After set default value: '" . $value . "'");
        }

        if ($required && !$value) {
            throw new \InvalidArgumentException(
                "Request " . $scope->value . " parameter '" . $name . "' is required, but not set."
            );
        }

        $this->logger->debug("Final resolved value: '" . $value . "'");

        yield match ($type) {
            'int' => $value ? (int)$value : 0,
            'float' => $value ? (float)$value : .0,
            'bool' => (bool)$value,
            'string' => $value ? (string)$value : ($nullable ? null : ''),
            null => null
        };
    }

    private function getResolverShortClassName(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    private function getAttribute($attrs): RequestParamInterface
    {
        return $attrs[0]; // `<ParamInterface>` is not repeatable
    }

    private function getAttributeShortClassName(object $attr): string
    {
        return (new \ReflectionClass($attr))->getShortName();
    }
}