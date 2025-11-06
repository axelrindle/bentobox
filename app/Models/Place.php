<?php

namespace App\Models;

use App\Models\Traits\HasData;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperPlace
 */
class Place extends Model
{
    use HasData,
        HasFactory,
        HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
    ];

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }
}
