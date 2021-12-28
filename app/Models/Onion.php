<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onion extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_whom',
        'car_number',
        'driver_name',
        'supply_cost',
        'cost',
        'type',
        'red_bag_number',
        'yellow_bag_number',
        'lom_bag_number',
        'onion_price',
        'total_weight',
        'onion_trash'
    ];

    protected $casts = [
        'onion_trash' => 'boolean'
    ];

    public function scopeTotalWeight($query)
    {
        return $query->where('total_weight', '!=', 0);
    }

    public function scopeNotTrash($query)
    {
        return $query->where('onion_trash', false);
    }
}
