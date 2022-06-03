<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class IsUserFridge extends Constraint
{
    public $userNull = 'User can\'t be null';
    public $isNotUserFridge = 'It\'s not your fridge';

    public function validatedBy(): string
    {
        return IsUserFridgeValidator::class;
    }
}