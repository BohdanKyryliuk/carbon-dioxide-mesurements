<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    use HasFactory;
    use HasRelationships;

    protected $fillable = [
        'sensor_id',
        'start_time',
        'end_time',
        'mesurement1',
        'mesurement2',
        'mesurement3',
    ];

    protected $casts = [
        'sensor_id' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'mesurement1' => 'integer',
        'mesurement2' => 'integer',
        'mesurement3' => 'integer',
    ];

    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class);
    }
}
