<?php

use App\Enums\SensorStatus;
use App\Models\Sensor;
use App\Models\Status;

it('gets sensor status', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);
    Status::factory()->create([
        'sensor_id' => $sensor,
        'name' => SensorStatus::OK,
    ]);

    $response = $this->get(route('api.status', [$uuid]));

    $response->assertOK();
    $response->assertExactJson([
        'status' => SensorStatus::OK,
    ]);
});

it('does not find sensor', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create();
    Status::factory()->create([
        'sensor_id' => $sensor,
        'name' => SensorStatus::OK,
    ]);

    $response = $this->get(route('api.status', [$uuid]));

    $response->assertNotFound();
    $response->assertExactJson([
        'title' => 'not found',
    ]);
});

it('does not find sensor status', function () {
    $uuid = $this->faker()->uuid();
    Sensor::factory()->create(['uuid' => $uuid]);

    $response = $this->get(route('api.status', [$uuid]));

    $response->assertNotFound();
    $response->assertExactJson([
        'title' => 'not found',
    ]);
});
