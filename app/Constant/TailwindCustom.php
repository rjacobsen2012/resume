<?php

namespace App\Constant;

class TailwindCustom
{
    public static function randomBgColor(): string
    {
        $numbers = TailwindColorNumbers::all();
        $colors = TailwindColorNames::all();

        return 'bg-'.
            ($colors[mt_rand(0, count($colors) - 1)]).'-'.
            ($numbers[mt_rand(0, count($numbers) - 1)]);
    }
}
