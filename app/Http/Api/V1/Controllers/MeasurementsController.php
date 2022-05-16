<?php

namespace App\Http\Api\V1\Controllers;

use App\Http\Api\V1\Requests\MeasurementsStoreRequest;
use App\Http\Controller;
use Illuminate\Http\JsonResponse;

class MeasurementsController extends Controller
{
    public function store(MeasurementsStoreRequest $request): JsonResponse
    {
        return response()->json(['OK'], 201);
    }
}
