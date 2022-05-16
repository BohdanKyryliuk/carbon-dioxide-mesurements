<?php

namespace App\Services\DataTransferObjects\Casters;

use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class TimeCaster implements Caster
{
    public function cast(mixed $value): Carbon
    {
        return Carbon::parse($value);
    }
}
