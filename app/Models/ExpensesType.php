<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensesType extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable;

    public const driver_cost = 1;
    public const custom_cost = 2;
    public const supply_cost = 3;
    public const market_cost = 4;
    public const other_cost = 5;
    public const warehouse_cost = 6;
    public const cost = 7;
    public const debt = 8;

    public static function expenseTypes($exceptCost = false, $without = null): array
    {
        return ExpensesType::query()
            ->when($without, fn($q) => $q->where('id', '!=', $without))
            ->when($exceptCost, fn($q) => $q->isNotCost())
            ->pluck('id', 'key')
            ->toArray();
    }

    protected $fillable = ['name', 'key'];

    public function scopeIsNotCost($query)
    {
        return $query->where('id', '!=', self::cost);
    }
}
