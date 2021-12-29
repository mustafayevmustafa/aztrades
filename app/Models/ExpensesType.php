<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Altek\Eventually\Eventually;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensesType extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable, Eventually;

    public const driver_cost = 1;
    public const custom_cost = 2;
    public const supply_cost = 3;
    public const market_cost = 4;
    public const other_cost = 5;
    public const cost = 6;

    public static function costTypes(): array
    {
        return [
            'driver_cost' => self::driver_cost,
            'custom_cost' => self::custom_cost,
            'supply_cost' => self::supply_cost,
            'market_cost' => self::market_cost,
            'other_cost'  => self::other_cost,
            'cost'        => self::cost
        ];
    }

    protected $fillable = ['name', 'key'];

    public function scopeIsNotCost($query)
    {
        return $query->where('key', '!=', 'cost');
    }

}
