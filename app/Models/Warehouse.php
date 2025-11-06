<?php

namespace App\Models;

use App\Models\Traits\HasData;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperWarehouse
 */
class Warehouse extends Model
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

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}
