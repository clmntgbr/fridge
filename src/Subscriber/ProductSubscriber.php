<?php

namespace App\Subscriber;

use App\Entity\Product;
use App\Helper\ProductStatusHelper;
use App\Lists\ProductStatusReference;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class ProductSubscriber implements EventSubscriber
{
    public function __construct(
        private ProductStatusHelper $productStatusHelper
    )
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Product) {
            return;
        }

        $this->productStatusHelper->setStatus(
            ProductStatusReference::WAITING_VALIDATION,
            $entity
        );
    }
}