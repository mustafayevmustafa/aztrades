<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;

    protected $fillable = ['is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public static function dailyNetIncome(): float
    {
        $selling = Selling::where('status', false)->whereDate('created_at', now())->get()->sum('price') -
            Expense::where('is_returned', false)->where('is_income', false)->where(function ($q){
                $q->where(fn($q) => $q->whereNotNull('goods_type')->where('expense_type_id', '!=', ExpensesType::debt))
                    ->orWhereNull('goods_type');
            })->whereDate('created_at', now())->get()->sum('expense') + Expense::where('is_returned', false)->where('is_income', true)->sum('expense');

        return ($selling - ClosedRate::dailyClosedRates()->sum('pocket')) ?? 0;
    }

    public static function dailyTurnover(): float
    {
        return (Selling::whereDate('created_at', now())->get()->sum('price') - ClosedRate::dailyClosedRates()->sum('turnover')) ?? 0;
    }

    public function dailyWaitingDebts(): float
    {
        return (Expense::where('is_returned', false)->where('is_income', false)->where('expense_type_id', ExpensesType::debt)->whereDate('created_at', now())->get()->sum('expense') - ClosedRate::dailyClosedRates()->sum('waiting_debts')) ?? 0;
    }

    public function dailyExpenses(): float
    {
        return (Expense::where('is_returned', false)->where('expense_type_id', '!=', ExpensesType::debt)->whereDate('created_at', now())->get()->sum('expense') - ClosedRate::dailyClosedRates()->sum('expenses')) ?? 0;
    }
}
