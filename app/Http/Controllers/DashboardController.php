<?php

namespace App\Http\Controllers;

use App\Models\ClosedRate;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Admin.index')->with([
            // closed rates
            'closed_rates' => ClosedRate::latest()->limit(10)->get(),
            // goods
            'onions' => Onion::isActive()->latest('updated_at')->get(),
            'potatoes' => Potato::isActive()->latest('updated_at')->get(),
            // total data
            'total_income' => Selling::get()->sum('price'),
            'total_expense' => Expense::where('is_income', false)->where('expense_type_id', '!=', ExpensesType::debt)->get()->sum('expense'),
            // monthly data
            'monthly_income' => Selling::whereMonth('created_at', now()->month)->get()->sum('price'),
            'monthly_expense' => Expense::where('is_income', false)->where('expense_type_id', '!=', ExpensesType::debt)->whereMonth('created_at', now()->month)->get()->sum('expense'),
            // daily data
            'daily_net_income' => Setting::currentNetIncome(),
            'daily_income' => Setting::currentTurnover(),
            'daily_waiting_income' => Setting::currentWaitingDebts(),
            'daily_waiting_income_debt' => Setting::currentWaitingIncomeDebts(),
            'daily_waiting_income_goods' => Setting::currentWaitingIncomeGoods(),
            'daily_expense' => Setting::currentExpenses(),
        ]);
    }

    public function toggleActive(): JsonResponse
    {
        $setting = Setting::first();
        $setting->update(['is_active' => !$setting->getAttribute('is_active')]);

        if (!$setting->getAttribute('is_active') &&
            (
                Setting::currentNetIncome() != 0 ||
                Setting::currentTurnover() != 0 ||
                Setting::currentWaitingDebts() != 0 ||
                Setting::currentWaitingIncomeDebts() != 0 ||
                Setting::currentExpenses() != 0
            )
        ) {
            $rate = ClosedRate::create([
                'pocket' => Setting::currentNetIncome(),
                'turnover' => Setting::currentTurnover(),
                'waiting_debts' => Setting::currentWaitingDebts(),
                'waiting_income_debts' => Setting::currentWaitingIncomeDebts(),
                'waiting_income_goods' => Setting::currentWaitingIncomeGoods(),
                'expenses' => Setting::currentExpenses(),
            ]);

            Selling::whereNull('closed_rate_id')->update([
                'closed_rate_id' => $rate->getAttribute('id')
            ]);

            Expense::whereNull('closed_rate_id')->update([
                'closed_rate_id' => $rate->getAttribute('id')
            ]);
        }

        return response()->json(['code' => 200]);
    }

    public function test()
    {
        foreach (Expense::where('expense_type_id', 8)->get() as $e) {
            $e->selling()->update(['sellingable_type' => $e->getAttribute('goods_type')]);
        }
    }
}
