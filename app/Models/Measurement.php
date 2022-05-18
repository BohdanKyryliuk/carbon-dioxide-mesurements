<?php

namespace App\Models;

use App\Enums\ConsecutiveMeasurements;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Measurement extends Model
{
    use HasFactory;
    use HasRelationships;

    protected $fillable = [
        'sensor_id',
        'co2',
        'time',
    ];

    protected $casts = [
        'id' => 'integer',
        'sensor_id' => 'integer',
        'co2' => 'integer',
        'time' => 'datetime',
    ];

    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class);
    }
}
