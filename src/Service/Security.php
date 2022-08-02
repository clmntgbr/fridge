<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Security as SymfonySecurity;

class Security
{
    public function __construct(
        private SymfonySecurity $security
    )
    {
    }

    public function getUser(): ?User
    {
        /** @var ?User $user */
        $user = $this->security->getUser();

        if (null === $user) {
            return null;
        }
        
        return $user;
    }
}