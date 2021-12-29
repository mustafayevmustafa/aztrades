<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Altek\Eventually\Eventually;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Potato extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable, Eventually;

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

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class)->withDefault();
    }

    public function getInfoAttribute(): string
    {
        return "{$this->getAttribute('from_whom')} ({$this->getAttribute('car_number')}) ({$this->getRelationValue('country')->getAttribute('name')} #{$this->getAttribute('id')})";
    }

    public function expenses()
    {
        return  Expense::where('goods_type', Potato::class)->where('goods_type_id', $this->getAttribute('id'));
    }
}
