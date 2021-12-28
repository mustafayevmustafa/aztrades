<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Potato extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'from_whom',
        'car_number',
        'driver_name',
        'driver_cost',
        'custom_cost',
        'cost',
        'market_cost',
        'other_cost',
        'total_weight',
        'country_id',
        'party',
        'is_trash',
    ];

    protected $casts = [
        'is_trash' => 'boolean'
    ];

    public function scopeHasWeight($query)
    {
        return $query->where('total_weight', '!=', 0);
    }

    public function scopeNotTrash($query)
    {
        return $query->where('is_trash', false);
    }

    public function sacs(): HasMany
    {
        return $this->hasMany(PotatoSac::class);
    }

    public function sellings(): MorphMany
    {
        return $this->morphMany(Selling::class, 'sellingable');
    }
}
