<?php

use App\Http\Api\V1\Controllers\MeasurementsController;
use App\Http\Api\V1\Controllers\SensorStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.')
    ->prefix('v1')
    ->group(function () {
        Route::post('/sensors/{uuid}/mesurements', [MeasurementsController::class, 'store'])
            ->whereUuid('uuid')
            ->name('measurements');

        Route::get('/sensors/{uuid}', [SensorStatusController::class, 'index'])
            ->whereUuid('uuid')
            ->name('status');
    });
