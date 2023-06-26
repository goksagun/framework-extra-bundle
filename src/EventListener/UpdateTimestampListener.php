<?php

namespace Goksagun\FrameworkExtraBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Goksagun\FrameworkExtraBundle\Doctrine\ORM\Mapping\UpdateTimestamp;

use function Symfony\Component\Clock\now;

class UpdateTimestampListener
{
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        $reflect = new \ReflectionObject($entity);

        foreach ($reflect->getProperties() as $property) {
            $attributes = $property->getAttributes(UpdateTimestamp::class);

            if ($attributes) {
                $property->setValue($entity, now());
            }
        }
    }
}