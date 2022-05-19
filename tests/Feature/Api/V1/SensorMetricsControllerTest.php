<?php

use App\Models\Measurement;
use App\Models\Sensor;

it('gets sensor metrics', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);

    Measurement::factory()
        ->times(3)
        ->sequence(
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'co2' => 2100,
                'time' => now(),
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

    $response = $this->get(route('api.metrics', [$uuid]));

    $response->assertOK();
    $response->assertExactJson([
        'maxLast30Days' => $sensor->measurementMaxLast30Days(),
        'avgLast30Days' => $sensor->measurementAVGLast30Days(),
    ]);
});

it('does not find sensor', function () {
    $uuid = $this->faker()->uuid();
    Sensor::factory()->create();

    $response = $this->get(route('api.metrics', [$uuid]));

    $response->assertNotFound();
    $response->assertExactJson([
        'title' => 'not found',
    ]);
});
