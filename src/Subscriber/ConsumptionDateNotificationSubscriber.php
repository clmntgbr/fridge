<?php

namespace App\Subscriber;

use App\Entity\ConsumptionDateNotification;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

class ConsumptionDateNotificationSubscriber implements EventSubscriber
{
    public function __construct(
        private Security $security
    )
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof ConsumptionDateNotification) {
            return;
        }

        if (null === $entity->getUser()) {
            $entity->setUser($this->security->getUser());
        }
    }
}