<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
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
}
