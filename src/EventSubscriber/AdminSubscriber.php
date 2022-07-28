<?php

namespace App\EventSubscriber;

use App\Model\TimestampedInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => ['setEntityUpdatedAt'],
        ];
    }

    public function setEntityUpdatedAt(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof TimestampedInterface) {
            return;
        }

        $entity->setUpdatedAt(new \DateTimeImmutable());
    }
}