<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class IsDatePassedValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof \DateTime) {
            $this->context->addViolation($constraint->isDateNotCorrect);
        }

        $date = new \DateTime('now');

        if ($value <= $date) {
            $this->context->addViolation($constraint->isDatePassed);
        }
    }
}