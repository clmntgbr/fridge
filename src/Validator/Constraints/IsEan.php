<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class IsEan extends Constraint
{
    public $message = '"%string%" is not a valid EAN code.';

    public function validatedBy(): string
    {
        return IsEanValidator::class;
    }
}