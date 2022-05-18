<?php

namespace App\Services\Actions;

use App\Models\Sensor;
use Spatie\QueueableAction\QueueableAction;

class CreateAlertAction
{
    use QueueableAction;

    public function execute(Sensor $sensor): void
    {
        $lastThreeMeasurements = $sensor->lastThreeMeasurements();
        $items = $lastThreeMeasurements->all();
        $measurement1 = $lastThreeMeasurements->last();
        $measurement2 = $items[1];
        $measurement3 = $lastThreeMeasurements->first();

        $sensor->alert()->create([
            'start_time' => $measurement1->time,
            'mesurement1' => $measurement1->co2,
            'mesurement2' => $measurement2->co2,
            'mesurement3' => $measurement3->co2,
        ]);
    }
}
