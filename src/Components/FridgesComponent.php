<?php

namespace App\Components;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\Security;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('fridges')]
class FridgesComponent
{
    public function __construct(
        private Security $security
    ) {
    }

    /** @return array|Collection */
    public function getFridges()
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if (null === $user) {
            return [];
        }

        return $user->getFridges();
    }
}