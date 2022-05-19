<?php

use App\Models\Measurement;
use App\Models\Sensor;
use App\Services\Actions\CreateAlertAction;
use Illuminate\Support\Facades\App;

it('creates alert', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);
    $measurementOneTime = now();

    Measurement::factory()
        ->times(3)
        ->sequence(
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'co2' => 2100,
                'time' => $measurementOneTime,
            ],
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'co2' => 2200,
                'time' => now()->addMinute(),
            ],
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'co2' => 2300,
                'time' => now()->addMinutes(2),
            ],
        )
        ->create();

    App::make(CreateAlertAction::class)->execute($sensor);

    $this->assertDatabaseHas('alerts', [
        'sensor_id' => $sensor->id,
        'start_time' => $measurementOneTime->toDateTimeString(),
        'end_time' => null,
        'mesurement1' => 2100,
        'mesurement2' => 2200,
        'mesurement3' => 2300,
    ]);
});
