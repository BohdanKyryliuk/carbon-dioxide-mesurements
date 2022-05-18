<?php

namespace App\Http\Api\V1\Controllers;

use App\Http\Api\V1\Resources\AlertResource;
use App\Http\Controller;
use App\Models\Sensor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AlertsController extends Controller
{
    public function index(string $uuid): JsonResponse|AnonymousResourceCollection
    {
        /** @var \App\Models\Sensor|null $sensor */
        $sensor = Sensor::query()
            ->whereUuid($uuid)
            ->first();

        if (empty($sensor)) {
            return $this->notFound();
        }

        $alerts = $sensor->alert()
            ->get()
            ->all();

        return AlertResource::collection($alerts);
    }
}
