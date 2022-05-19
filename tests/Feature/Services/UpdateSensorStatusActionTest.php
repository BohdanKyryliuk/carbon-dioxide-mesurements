<?php

use App\Enums\SensorStatus;
use App\Models\Measurement;
use App\Models\Sensor;
use App\Models\Status;
use App\Services\Actions\CreateAlertAction;
use App\Services\Actions\UpdateAlertAction;
use App\Services\Actions\UpdateSensorStatusAction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Queue;
use Spatie\QueueableAction\Testing\QueueableActionFake;

it('updates sensor status to OK', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);

    $measurement = Measurement::factory()->create([
        'sensor_id' => $sensor,
        'co2' => 1900,
        'time' => now(),
    ]);

    App::make(UpdateSensorStatusAction::class)->execute($measurement, $sensor);

    $this->assertDatabaseHas('statuses', [
        'sensor_id' => $sensor->id,
        'name' => SensorStatus::OK,
    ]);
});

it('updates sensor status to WARN', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);

    $measurement = Measurement::factory()->create([
        'sensor_id' => $sensor,
        'co2' => 2100,
        'time' => now(),
    ]);

    App::make(UpdateSensorStatusAction::class)->execute($measurement, $sensor);

    $this->assertDatabaseHas('statuses', [
        'sensor_id' => $sensor->id,
        'name' => SensorStatus::WARN,
    ]);
});

it('updates sensor status to ALERT and fires storing of alert', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);

    $measurements = Measurement::factory()
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

    Queue::fake();

    App::make(UpdateSensorStatusAction::class)->execute($measurements->last(), $sensor);

    QueueableActionFake::assertPushed(CreateAlertAction::class);

    $this->assertDatabaseHas('statuses', [
        'sensor_id' => $sensor->id,
        'name' => SensorStatus::ALERT,
    ]);
});

it('updates sensor status to OK and fires updating of alert', function () {
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);

    Status::factory()->create([
        'sensor_id' => $sensor->id,
        'name' => SensorStatus::ALERT,
    ]);

    $measurements = Measurement::factory()
        ->times(3)
        ->sequence(
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'co2' => 2000,
                'time' => now(),
            ],
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'co2' => 1900,
                'time' => now()->addMinute(),
            ],
            fn ($sequence) => [
                'sensor_id' => $sensor,
                'co2' => 1800,
                'time' => now()->addMinutes(2),
            ],
        )
        ->create();

    Queue::fake();

    App::make(UpdateSensorStatusAction::class)->execute($measurements->last(), $sensor);

    QueueableActionFake::assertPushed(UpdateAlertAction::class);

    $this->assertDatabaseHas('statuses', [
        'sensor_id' => $sensor->id,
        'name' => SensorStatus::OK,
    ]);
});
