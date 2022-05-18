<?php

namespace App\Services\Actions;

use App\Models\Sensor;
use Carbon\Carbon;
use Spatie\QueueableAction\QueueableAction;

class UpdateAlertAction
{
    use QueueableAction;

    public function execute(Sensor $sensor, Carbon $endTime): void
    {
        $latestAlert = $sensor->latestAlert();

        $latestAlert->update([
            'end_time' => $endTime,
        ]);
    }
}
