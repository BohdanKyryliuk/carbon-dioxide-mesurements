<?php

use App\Services\Actions\StoreMeasurementsAction;
use Illuminate\Support\Facades\Queue;
use Spatie\QueueableAction\Testing\QueueableActionFake;

it('saves on store', function () {
    $co2 = $this->faker()->numberBetween(350, 10000);
    $time = $this->faker()->date('Y-m-d\TH:i:sP');
    $uuid = $this->faker()->uuid();

    Queue::fake();

    $response = $this->post(route('api.measurements', [$uuid]), [
        'co2' => $co2,
        'time' => $time,
    ]);

    QueueableActionFake::assertPushed(StoreMeasurementsAction::class);

    $response->assertCreated();
});
