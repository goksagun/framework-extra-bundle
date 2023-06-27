<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Doctrine\ORM\Events;
use Goksagun\FrameworkExtraBundle\EventListener\CreationTimestampListener;
use Goksagun\FrameworkExtraBundle\EventListener\UpdateTimestampListener;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\AbstractParamResolver;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\HeadersParamValueResolver;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\QueryParamValueResolver;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\RequestBodyValueResolver;
use Goksagun\FrameworkExtraBundle\ValueResolver\Resolver\RequestParamValueResolver;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services
        ->set(CreationTimestampListener::class)
        ->tag('doctrine.event_listener', ['event' => Events::prePersist]);

    $services
        ->set(UpdateTimestampListener::class)
        ->tag('doctrine.event_listener', ['event' => Events::preUpdate]);

    $services
        ->set(AbstractParamResolver::class)
        ->abstract()
        ->call('setLogger', [service('logger')]);

    $services
        ->set(RequestBodyValueResolver::class)
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