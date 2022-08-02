<?php

namespace App\Components;

use App\Entity\Fridge;
use App\Entity\Item;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('item_card')]
class ItemCardComponent
{
    public Fridge $fridge;
    public Item $item;
}