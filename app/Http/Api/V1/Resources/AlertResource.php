<?php

namespace App\Http\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Alert */
class AlertResource extends JsonResource
{
    /** @param  \Illuminate\Http\Request  $request */
    public function toArray($request)
    {
        return [
            'startTime' => $this->start_time,
            'endTime' => $this->end_time,
            'mesurement1' => $this->mesurement1,
            'mesurement2' => $this->mesurement2,
            'mesurement3' => $this->mesurement3,
        ];
    }
}
