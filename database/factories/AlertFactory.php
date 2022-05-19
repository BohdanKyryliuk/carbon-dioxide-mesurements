<?php

namespace Database\Factories;

use App\Models\Sensor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alert> */
class AlertFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'sensor_id' => Sensor::factory(),
            'start_time' => $startTime = $this->faker->dateTimeBetween('now', '+1 hour'),
            'end_time' => $this->faker->dateTimeInInterval($startTime, '+1 hour'),
            'mesurement1' => $this->faker->numberBetween(2100, 3500),
            'mesurement2' => $this->faker->numberBetween(2100, 3500),
            'mesurement3' => $this->faker->numberBetween(2100, 3500),
        ];
    }
}
