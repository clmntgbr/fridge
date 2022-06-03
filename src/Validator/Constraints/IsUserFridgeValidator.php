<?php

namespace App\Validator\Constraints;

use App\Entity\Fridge;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class IsUserFridgeValidator extends ConstraintValidator
{
    public function __construct(
        private Security $security
    )
    {
    }

    /**
     * @param Fridge $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            $this->context->addViolation($constraint->userNull, []);
        }

        if ($value->getUser()->getId() !== $user->getId()) {
            $this->context->addViolation($constraint->isNotUserFridge, []);
        }
    }
}