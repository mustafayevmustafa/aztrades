<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Altek\Eventually\Eventually;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Onion extends Model
{
    use SoftDeletes;

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
        'old_bag_numbers',
        'total_weight',
        'is_trash',
        'city_id'
    ];

    protected $casts = [
        'is_trash' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function (Onion $onion){
            $old_bag_numbers = "{$onion->getAttribute('red_bag_number')},{$onion->getAttribute('yellow_bag_number')},{$onion->getAttribute('lom_bag_number')}";
            $onion->setAttribute('old_bag_numbers', $old_bag_numbers);
        });

        self::updating(function (Onion $onion){
            $old_bag_numbers = "{$onion->getAttribute('red_bag_number')},{$onion->getAttribute('yellow_bag_number')},{$onion->getAttribute('lom_bag_number')}";
            $onion->setAttribute('old_bag_numbers', $old_bag_numbers);
        });
    }

    public function scopeHasGoods($query)
    {
        return $query->where('total_weight', '!=', 0)
            ->orWhere('red_bag_number', '!=', 0)
            ->orWhere('yellow_bag_number', '!=', 0)
            ->orWhere('lom_bag_number', '!=', 0);
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
        return "{$this->getAttribute('from_whom')} ({$this->getAttribute('car_number')}) ({$this->getRelationValue('city')->getAttribute('name')})";
    }

    public function expenses()
    {
        return  Expense::where('goods_type', Onion::class)->where('goods_type_id', $this->getAttribute('id'));
    }
}
