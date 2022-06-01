<?php

namespace App\Lists;

use App\Common\Traits\ListTrait;

class ProductStatusReference
{
    use ListTrait;

    public const WAITING_VALIDATION = "waiting_validation";
    public const VALIDATED = "validated";
}