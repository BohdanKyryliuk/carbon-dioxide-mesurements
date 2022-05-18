<?php

namespace App\Enums;

enum CarbonDioxideCriticalLevel : int
{
    case MIN = 2000;

    public static function isCritical(int $co2): bool
    {
        return $co2 > self::MIN->value;
    }
}
