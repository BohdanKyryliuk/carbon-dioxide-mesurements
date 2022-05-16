<?php

namespace App\Http\Api\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeasurementsStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'co2' => ['required', 'integer', 'between:350,10000'],
            'time' => ['required', 'date_format:Y-m-d\TH:i:sP']
        ];
    }
}
