<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Onion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'from_whom',
        'car_number',
        'driver_name',
        'driver_cost',
        'supply_cost',
        'cost',
        'red_bag_number',
        'yellow_bag_number',
        'lom_bag_number',
        'total_weight',
        'is_trash',
        'city_id'
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

    public function sellings(): MorphMany
    {
        return $this->morphMany(Selling::class, 'sellingable');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault();
    }

    public function getInfoAttribute(): string
    {
        return "{$this->getAttribute('from_whom')} ({$this->getAttribute('car_number')}) ({$this->getRelationValue('city')->getAttribute('name')} #{$this->getAttribute('id')})";
    }
}
