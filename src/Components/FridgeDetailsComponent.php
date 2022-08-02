<?php

namespace App\Components;

use App\Entity\Fridge;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('fridge_details')]
class FridgeDetailsComponent
{
    public Fridge $fridge;

    public function getItemsCount(): int
    {
        return $this->fridge->getItems()->count();
    }

    public function getItems(): Collection
    {
        return $this->fridge->getItems();
    }
}