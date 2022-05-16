<?php

namespace App\Services\DataTransferObjects;

use App\Services\DataTransferObjects\Casters\TimeCaster;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\DefaultCast;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

#[
    DefaultCast(Carbon::class, TimeCaster::class),
]
class MeasurementsDTO extends DataTransferObject
{
    #[MapFrom('co2')]
    public int $co2;

    #[MapFrom('time')]
    public Carbon $time;
}
