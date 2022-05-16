<?php

namespace App\Services\Actions;

use App\Models\Measurement;
use App\Models\Sensor;
use App\Services\DataTransferObjects\MeasurementsDTO;
use Spatie\QueueableAction\QueueableAction;

class StoreMeasurementsAction
{
    use QueueableAction;

    public function execute(string $uuid, MeasurementsDTO $measurementsDTO): void
    {
        $sensor = Sensor::firstOrCreate(['uuid' => $uuid]);

        Measurement::create($measurementsDTO->all() + ['sensor_id' => $sensor->id]);
    }
}
