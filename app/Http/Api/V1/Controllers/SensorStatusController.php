<?php

namespace App\Http\Api\V1\Controllers;

use App\Http\Controller;
use App\Models\Sensor;
use Illuminate\Http\JsonResponse;

class SensorStatusController extends Controller
{
    public function index(string $uuid): JsonResponse
    {
        /** @var \App\Models\Sensor|null $sensor */
        $sensor = Sensor::query()
            ->whereUuid($uuid)
            ->first();

        if (empty($sensor)) {
            return $this->notFound();
        }

        $status = $sensor->status()->first();
        if (empty($status)) {
            return $this->notFound();
        }

        return response()->json(['status' => $status->name]);
    }
}
