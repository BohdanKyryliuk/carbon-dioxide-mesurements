<?php

namespace Database\Factories;

use App\Models\Sensor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Measurement> */
class MeasurementFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'sensor_id' => Sensor::factory(),
            'co2' => $this->faker->numberBetween(350, 10000),
            'time' => $this->faker->dateTime(),
        ];
    }
}
