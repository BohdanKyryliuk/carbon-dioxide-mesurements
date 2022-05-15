<?php

namespace App\Models;

use App\Enums\SensorStatus;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    use HasFactory;
    use HasRelationships;

    protected $fillable = [
        'sensor_id',
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
        'sensor_id' => 'integer',
        'name' => SensorStatus::class,
    ];

    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensor::class);
    }
}
