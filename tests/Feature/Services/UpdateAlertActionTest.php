<?php

use App\Models\Alert;
use App\Models\Sensor;
use App\Services\Actions\UpdateAlertAction;
use Illuminate\Support\Facades\App;

it('updates alert for sensor', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);
    $startTime = now();
    $endTime = now()->addMinutes(15);

    $oldAlert = Alert::factory()->create([
        'sensor_id' => $sensor->id,
        'start_time' => $startTime,
        'end_time' => null,
        'mesurement1' => 2100,
        'mesurement2' => 2200,
        'mesurement3' => 2300,
    ]);

    App::make(UpdateAlertAction::class)->execute($sensor, $endTime);

    $this->assertDatabaseHas('alerts', [
        'sensor_id' => $sensor->id,
        'start_time' => $startTime->toDateTimeString(),
        'end_time' => $endTime,
        'mesurement1' => 2100,
        'mesurement2' => 2200,
        'mesurement3' => 2300,
    ]);

    $this->assertDatabaseMissing('alerts', $oldAlert->toArray());
});
