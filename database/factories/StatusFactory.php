<?php

namespace Database\Factories;

use App\Enums\SensorStatus;
use App\Models\Sensor;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status> */
class StatusFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'sensor_id' => Sensor::factory(),
            'name' => $this->faker->randomElements(SensorStatus::cases()),
        ];
    }
}
