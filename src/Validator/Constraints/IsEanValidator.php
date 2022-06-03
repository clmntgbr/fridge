<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class IsEanValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $checkDigit = substr((string)$value, strlen((string)$value) - 1, strlen((string)$value));

        if ((!preg_match('/^[0-9]{8,13}$/', $value, $matches)
            || $this->getEanCheckDigit($value) != $checkDigit)) {
            $this->context->addViolation(
                $constraint->message,
                array('%string%' => $value)
            );
        }
    }

    /**
     * @param $value
     * @return float
     */
    private function getEanCheckDigit($value)
    {
        $evenSum = 0;
        $oddSum = 0;
        $digits = str_split(substr((string)$value, 0, -1));

        foreach ($digits as $index => $digit) {
            if ($index & 1) {
                $evenSum += strlen((string)$value) == 8 ? $digit : $digit * 3;
            } else {
                $oddSum += strlen((string)$value) == 8 ? $digit * 3 : $digit;
            }
        }

        $total = $evenSum + $oddSum;

        return ((ceil($total / 10)) * 10) - $total;
    }
}