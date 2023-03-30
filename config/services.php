<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\AbstractParamResolver;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\BodyValueResolver;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\HeadersParamValueResolver;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\QueryParamValueResolver;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\RequestParamValueResolver;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services
        ->set(AbstractParamResolver::class)
        ->abstract()
        ->call('setLogger', [service('logger')]);

    $services
        ->set(BodyValueResolver::class)
        ->arg('$serializer', service('serializer'))
        ->call('setLogger', [service('logger')])
        ->tag('controller.argument_value_resolver', ['priority' => 150]);

    $services
        ->set(HeadersParamValueResolver::class)
        ->parent(AbstractParamResolver::class)
        ->tag('controller.argument_value_resolver', ['priority' => 150])
        ->set(QueryParamValueResolver::class)
        ->parent(AbstractParamResolver::class)
        ->tag('controller.argument_value_resolver', ['priority' => 150])
        ->set(RequestParamValueResolver::class)
        ->parent(AbstractParamResolver::class)
        ->tag('controller.argument_value_resolver', ['priority' => 150]);
};