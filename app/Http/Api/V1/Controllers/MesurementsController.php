<?php

namespace App\Http\Api\V1\Controllers;

use App\Http\Api\V1\Requests\MesurementsStoreRequest;
use App\Http\Controller;
use Illuminate\Http\JsonResponse;

class MesurementsController extends Controller
{
    public function store(MesurementsStoreRequest $request): JsonResponse
    {
        return response()->json(['OK'], 201);
    }
}
