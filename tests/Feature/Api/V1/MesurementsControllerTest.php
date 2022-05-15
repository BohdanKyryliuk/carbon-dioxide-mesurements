<?php

it('saves on store', function () {
    $co2 = $this->faker()->numberBetween(350, 10000);
    $time = $this->faker()->date('Y-m-d\TH:i:sP');
    $uuid = $this->faker()->uuid();

    $response = $this->post(route('api.mesurements', [$uuid]), [
        'co2' => $co2,
        'time' => $time,
    ]);

    $response->assertCreated();
});
