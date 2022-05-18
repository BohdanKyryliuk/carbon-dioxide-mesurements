<?php

namespace App\Http\Api\V1\Controllers;

use App\Http\Api\V1\Requests\MeasurementsStoreRequest;
use App\Http\Controller;
use App\Services\Actions\StoreMeasurementsAction;
use App\Services\DataTransferObjects\MeasurementsDTO;
use Illuminate\Http\JsonResponse;

class MeasurementsController extends Controller
{
    public function store(
        string $uuid,
        MeasurementsStoreRequest $request,
        StoreMeasurementsAction $storeMeasurements,
    ): JsonResponse {
        $storeMeasurements->onQueue()->execute($uuid, new MeasurementsDTO($request->validated()));

        return $this->created();
    }
}
