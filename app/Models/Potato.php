<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Potato extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable;

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
        'status',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function scopeHasGoods($query)
    {
        return $query->where('total_weight', '!=', 0)
            ->orWhereHas('sacs');
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
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
        return "{$this->getAttribute('from_whom')} ({$this->getRelationValue('country')->getAttribute('name')}) (Partiya: {$this->getAttribute('party')})";
    }

    public function getLeastBagCountAttribute(): int
    {
        $least = PHP_INT_MAX;

        foreach ($this->getRelationValue('sacs') as $sac) {
            if($least > $sac->getAttribute('sac_count')) {
                $least = $sac->getAttribute('sac_count');
            }
        }

        return $least;
    }

    public function expenses()
    {
        return  Expense::where('goods_type', Potato::class)->where('goods_type_id', $this->getAttribute('id'));
    }

    public function waste(): MorphMany
    {
        return $this->morphMany(Waste::class, 'wastable');
    }
}
