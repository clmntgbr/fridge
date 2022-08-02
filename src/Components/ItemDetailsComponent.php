<?php

namespace App\Components;

use App\Entity\Item;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('item_details')]
class ItemDetailsComponent
{
    public Item $item;
}