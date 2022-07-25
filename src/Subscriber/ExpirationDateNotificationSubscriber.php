<?php

namespace App\Subscriber;

use App\Entity\ExpirationDateNotification;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

class ExpirationDateNotificationSubscriber implements EventSubscriber
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

        if (!$entity instanceof ExpirationDateNotification) {
            return;
        }

        if (null === $entity->getUser()) {
            $entity->setUser($this->security->getUser());
        }
    }
}