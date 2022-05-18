<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sensor extends Model
{
    use HasFactory;
    use BindsOnUuid;
    use GeneratesUuid;
    use HasRelationships;

    protected $fillable = [
        'uuid',
    ];

    public function scopeByUuid(Builder $builder, string $uuid): Model|null
    {
        return $builder
            ->whereUuid($uuid)
            ->first();
    }

    public function status(): HasOne
    {
        return $this->hasOne(Status::class);
    }

    public function alert(): HasMany
    {
        return $this->hasMany(Alert::class);
    }

    public function measurement(): HasMany
    {
        return $this->hasMany(Measurement::class);
    }

    public function measurementMaxLast30Days(): int
    {
        return $this->measurementLast30Days()
            ->max('co2');
    }

    public function measurementAVGLast30Days(): int
    {
        return $this->measurementLast30Days()
            ->avg('co2');
    }

    private function measurementLast30Days(): HasMany
    {
        return $this->measurement()
            ->select('co2')
            ->where('time', '>', now()->subDays(30));
    }
}
