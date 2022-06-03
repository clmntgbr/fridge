<?php

namespace App\Subscriber;

use App\Entity\Fridge;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

class FridgeSubscriber implements EventSubscriber
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
            Events::preRemove,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Fridge) {
            return;
        }

        if (null === $entity->getUser()) {
            $entity->setUser($this->security->getUser());
        }
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Fridge) {
            return;
        }

        $user = $entity->getUser();

        if ($user->getFridges()->count() === 1) {
            throw new \Exception('You can\'t delete this fridge');
        }
    }
}