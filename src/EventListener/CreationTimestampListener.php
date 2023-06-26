<?php

namespace Goksagun\FrameworkExtraBundle\EventListener;

use Doctrine\ORM\Event\PrePersistEventArgs;
use Goksagun\FrameworkExtraBundle\Doctrine\ORM\Mapping\CreateTimestamp;

use function Symfony\Component\Clock\now;

class CreationTimestampListener
{
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        $reflect = new \ReflectionObject($entity);

        foreach ($reflect->getProperties() as $property) {
            $attributes = $property->getAttributes(CreateTimestamp::class);

            if ($attributes) {
                $property->setValue($entity, now());
            }
        }
    }
}