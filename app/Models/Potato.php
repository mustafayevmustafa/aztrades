<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Potato extends Model
{
    use HasFactory;

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
        'potato_price'
    ];

    public function sacs(): HasMany
    {
        return $this->hasMany(PotatoSac::class);
    }
}
