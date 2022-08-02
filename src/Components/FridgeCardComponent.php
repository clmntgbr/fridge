<?php

namespace App\Components;

use App\Entity\Fridge;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('fridge_card')]
class FridgeCardComponent
{
    public Fridge $fridge;
}