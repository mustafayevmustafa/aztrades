<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;

    protected $fillable = ['is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public static function getDailyNetIncome()
    {
        return Selling::where('status', false)->whereDate('created_at', now())->get()->sum('price') -
        Expense::where('is_returned', false)->where(function ($q){
            $q->where(fn($q) => $q->whereNotNull('goods_type')->where('expense_type_id', '!=', ExpensesType::debt))
                ->orWhereNull('goods_type');
        })->whereDate('created_at', now())->get()->sum('expense') - ClosedRate::dailyClosedRates();
    }
}
