<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;

    protected $fillable = ['is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public static function currentNetIncome(): float
    {
        $selling = Selling::where('was_debt', false)->whereNull('closed_rate_id')->sum('price') -
            Expense::where('is_income', false)->whereNull('closed_rate_id')->where(function ($q){
                $q->where(fn($q) => $q->whereNotNull('goods_type')->where('expense_type_id', '!=', ExpensesType::debt))
                    ->orWhereNull('goods_type');
            })->get()->sum('expense') + Expense::where('is_income', true)->sum('expense');

        return $selling  ?? 0;
    }

    public static function currentTurnover(): float
    {
        return Selling::whereNull('closed_rate_id')->get()->sum('price') ?? 0;
    }

    public function currentWaitingDebts(): float
    {
        return Expense::where('is_income', false)->whereNull('closed_rate_id')->whereNull('goods_type')->where('expense_type_id', ExpensesType::debt)->get()->sum('expense') ?? 0;
    }

    public function currentWaitingIncomeGoods(): float
    {
        return Expense::where('is_income', false)->whereNull('closed_rate_id')->whereNotNull('goods_type')->where('expense_type_id', ExpensesType::debt)->get()->sum('expense') ?? 0;
    }

    public function currentWaitingIncomeDebts(): float
    {
        return Expense::where('is_income', true)->whereNull('closed_rate_id')->where('expense_type_id', ExpensesType::debt)->get()->sum('expense') ?? 0;
    }

    public function currentExpenses(): float
    {
        return Expense::where('expense_type_id', '!=', ExpensesType::debt)->whereNull('closed_rate_id')->get()->sum('expense') ?? 0;
    }
}
