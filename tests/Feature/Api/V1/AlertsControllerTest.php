<?php

use App\Models\Alert;
use App\Models\Sensor;

it('fetches alerts for sensor', function () {
    $alertOneStartTime = now()->toAtomString();
    $alertOneEndTime = now()->addMinutes(15)->toAtomString();
    $alertTwoStartTime = now()->addHour()->toAtomString();
    $alertTwoEndTime = now()->addHour()->addMinutes(15)->toAtomString();

    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);

    Alert::factory()
        ->times(2)
        ->sequence(
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'start_time' => $alertOneStartTime,
                'end_time' => $alertOneEndTime,
                'mesurement1' => 2100,
                'mesurement2' => 2200,
                'mesurement3' => 2300,
            ],
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'start_time' => $alertTwoStartTime,
                'end_time' => $alertTwoEndTime,
                'mesurement1' => 2500,
                'mesurement2' => 2600,
                'mesurement3' => 2700,
            ],
        )
        ->create();

    $response = $this->get(route('api.alerts', [$uuid]));

    $response->assertOK();
    $response->assertExactJson([
        [
            'startTime' => $alertOneStartTime,
            'endTime' => $alertOneEndTime,
            'mesurement1' => 2100,
            'mesurement2' => 2200,
            'mesurement3' => 2300,
        ],
        [
            'startTime' => $alertTwoStartTime,
            'endTime' => $alertTwoEndTime,
            'mesurement1' => 2500,
            'mesurement2' => 2600,
            'mesurement3' => 2700,
        ],
    ]);
});

it('does not find sensor', function () {
    $uuid = $this->faker()->uuid();
    Sensor::factory()->create();

    $response = $this->get(route('api.alerts', [$uuid]));

    $response->assertNotFound();
    $response->assertExactJson([
        'title' => 'not found',
    ]);
});
