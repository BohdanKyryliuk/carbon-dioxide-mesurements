<?php

use App\Models\Sensor;
use App\Services\Actions\StoreMeasurementsAction;
use App\Services\Actions\UpdateSensorStatusAction;
use App\Services\DataTransferObjects\MeasurementsDTO;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Queue;
use Spatie\QueueableAction\Testing\QueueableActionFake;

it('stores measurements', function () {
    $co2 = $this->faker()->numberBetween(350, 10000);
    $time = $this->faker()->date('Y-m-d\TH:i:sP');
    $uuid = $this->faker()->uuid();
    $sensor = Sensor::factory()->create(['uuid' => $uuid]);

    $measurementsDTO = new MeasurementsDTO([
        'co2' => $co2,
        'time' => $time,
    ]);

    Queue::fake();

    App::make(StoreMeasurementsAction::class)->execute($uuid, $measurementsDTO);

    QueueableActionFake::assertPushed(UpdateSensorStatusAction::class);

    $this->assertDatabaseHas('measurements', [
        'sensor_id' => $sensor->id,
        'co2' => $co2,
        'time' => $time,
    ]);
});
