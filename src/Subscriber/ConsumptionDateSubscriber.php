<?php

namespace App\Subscriber;

use App\Entity\ConsumptionDate;
use App\Repository\ConsumptionDateRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class ConsumptionDateSubscriber implements EventSubscriber
{
    public function __construct(
        private EntityManagerInterface $em,
        private ConsumptionDateRepository $consumptionDateRepository
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

        if (!$entity instanceof ConsumptionDate) {
            return;
        }

        $consumptionDates = $this->consumptionDateRepository->findBy(['item' => $entity->getItem()]);

        foreach ($consumptionDates as $consumptionDate) {
            $consumptionDate->setItem(null);
            $this->em->persist($consumptionDate);
            $this->em->flush();
        }
    }
}