<?php

namespace App\Services\Actions;

use App\Enums\CarbonDioxideCriticalLevel;
use App\Enums\ConsecutiveMeasurements;
use App\Enums\SensorStatus;
use App\Models\Measurement;
use App\Models\Sensor;
use App\Models\Status;
use Spatie\QueueableAction\QueueableAction;

class UpdateSensorStatusAction
{
    use QueueableAction;

    public function __construct(
        private readonly CreateAlertAction $createAlert,
        private readonly UpdateAlertAction $updateAlert,
    ) {
    }

    public function execute(Measurement $measurement, Sensor $sensor): void
    {
        // OK
        $status = SensorStatus::OK;
        $currentSensorStatus = $sensor->status()->first();
        $isCurrentStatusAlert = $currentSensorStatus?->name == SensorStatus::ALERT;

        /** @var \Illuminate\Database\Eloquent\Collection $lastThreeMeasurements */
        $lastThreeMeasurements = $sensor->lastThreeMeasurements();
        $criticalMeasurements = $lastThreeMeasurements->filter(
            fn (Measurement $measurement) => CarbonDioxideCriticalLevel::isCritical($measurement->co2)
        );
        $safeMeasurements = $lastThreeMeasurements->filter(
            fn (Measurement $measurement) => ! CarbonDioxideCriticalLevel::isCritical($measurement->co2)
        );

        // WARN
        if (CarbonDioxideCriticalLevel::isCritical($measurement->co2)) {
            $status = SensorStatus::WARN;
        }

        // ALERT
        // If the service receives 3 or more consecutive measurements higher than
        // 2000 the sensor status should be set to ALERT
        if ($criticalMeasurements->count() == ConsecutiveMeasurements::COUNT->value) {
            $status = SensorStatus::ALERT;

            if (! $isCurrentStatusAlert) {
                $this->createAlert->onQueue()->execute($sensor);
            }
        }

        if ($isCurrentStatusAlert) {
            // When the sensor reaches to status ALERT it stays in this state until it receives 3
            // consecutive measurements lower than 2000; then it moves to OK
            $isOkay = $safeMeasurements->count() == ConsecutiveMeasurements::COUNT->value;
            if ($isOkay) {
                $this->updateAlert->onQueue()->execute($sensor, $safeMeasurements->first()->time);
            }

            $status = $isOkay ? SensorStatus::OK : SensorStatus::ALERT;
        }

        Status::updateOrCreate(['sensor_id' => $measurement->sensor_id], ['name' => $status]);
    }
}
