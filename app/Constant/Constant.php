<?php

namespace App\Constant;

use ReflectionClass;

abstract class Constant
{
    public static function all(): array
    {
        return array_values((new ReflectionClass(static::class))->getConstants());
    }
}