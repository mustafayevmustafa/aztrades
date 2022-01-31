<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Onion extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable;

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
        'old_total_weight',
        'city_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function (Onion $onion){
            $old_bag_numbers = "{$onion->getAttribute('red_bag_number')},{$onion->getAttribute('yellow_bag_number')},{$onion->getAttribute('lom_bag_number')}";
            $onion->setAttribute('old_bag_numbers', $old_bag_numbers);
            $onion->setAttribute('old_total_weight', $onion->getAttribute('total_weight'));
        });

        self::updating(function (Onion $onion){
            if (!\request()->has('is_waste')) {
                $old_bags = explode(',', $onion->getAttribute('old_bag_numbers'));

                $red = $onion->isDirty('red_bag_number') ? $onion->getAttribute('red_bag_number') : $old_bags[0];
                $yellow = $onion->isDirty('yellow_bag_number') ? $onion->getAttribute('red_bag_number') : $old_bags[1];
                $lom = $onion->isDirty('lom_bag_number') ? $onion->getAttribute('red_bag_number') : $old_bags[2];

                $old_bag_numbers = "$red,$yellow,$lom";

                $onion->setAttribute('old_bag_numbers', $old_bag_numbers);
                $onion->setAttribute('old_total_weight', $onion->isDirty('total_weight') ?
                    $onion->getAttribute('total_weight') :
                    $onion->getAttribute('old_total_weight')
                );
            }
        });
    }

    public static function bags(): array
    {
        return [
            'yellow_bag_number' => 'Sarı Kisə',
            'red_bag_number' => 'Qırmızı Kisə',
            'lom_bag_number' => 'Lom Kisə'
        ];
    }

    public function scopeHasGoods($query)
    {
        return $query->where('total_weight', '!=', 0)
            ->orWhere('red_bag_number', '!=', 0)
            ->orWhere('yellow_bag_number', '!=', 0)
            ->orWhere('lom_bag_number', '!=', 0);
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
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

    public function getLeastBagCountAttribute(): ?int
    {
        $least = $this->getAttribute('red_bag_number');

        if ($least > $this->getAttribute('yellow_bag_number')) {
            $least = $this->getAttribute('yellow_bag_number');
        }

        if ($least > $this->getAttribute('lom_bag_number')) {
            $least = $this->getAttribute('lom_bag_number');
        }

        return $least;
    }

    public function expenses()
    {
        return  Expense::where('goods_type', Onion::class)->where('goods_type_id', $this->getAttribute('id'));
    }

    public function waste(): MorphMany
    {
        return $this->morphMany(Waste::class, 'wastable');
    }

    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
