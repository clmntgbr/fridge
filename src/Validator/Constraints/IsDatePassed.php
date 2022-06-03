<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class IsDatePassed extends Constraint
{
    public $isDatePassed = 'This date is already passed';
    public $isDateNotCorrect = 'This date is not correct';

    public function validatedBy(): string
    {
        return IsDatePassedValidator::class;
    }
}