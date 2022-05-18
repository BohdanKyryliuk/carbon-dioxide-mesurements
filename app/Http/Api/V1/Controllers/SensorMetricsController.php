<?php

namespace App\Http\Api\V1\Controllers;

use App\Http\Controller;
use App\Models\Sensor;

class SensorMetricsController extends Controller
{
    public function index(string $uuid)
    {
        /** @var \App\Models\Sensor|null $sensor */
        $sensor = Sensor::byUuid($uuid);

        if (empty($sensor)) {
            return $this->notFound();
        }

        return response()->json([
            'maxLast30Days' => $sensor->measurementMaxLast30Days(),
            'avgLast30Days' => $sensor->measurementAVGLast30Days(),
        ]);
    }
}
